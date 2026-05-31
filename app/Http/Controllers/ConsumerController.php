<?php

namespace App\Http\Controllers;

use App\Models\TrackableItem;
use Illuminate\Http\Request;
use App\Models\Report;

use App\Models\AllocationBatch;
use App\Models\SubsidizedAllocation;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;



class ConsumerController extends Controller
{
    // The main public search landing page
    public function index()
    {
        // Consumers only see active batches
        $availableProducts = AllocationBatch::with(['subsidizedAllocations' => function($query) {
            // Potentially filter by the user's specific state if you have that data
            $query->where('remaining_quota', '>', 0);
        }])->latest()->paginate(9);

        return view('consumer.dashboard', compact('availableProducts'));
    }

    public function show(AllocationBatch $batch)
    {
        // Fetch only the allocation for the user's specific state
        $allocation = $batch->subsidizedAllocations()
            ->where('state_name', auth()->user()->state) 
            ->first();

        $stateQuota = SubsidizedAllocation::where('state_name', auth()->user()->state)
            ->sum('remaining_quota');

        if (!$allocation) {
            return redirect()->route('consumer.dashboard')
                ->with('error', 'No distribution found for ' . auth()->user()->state);
        }

        // --- UPDATED LOGIC ---
        // Look up orders specifically tied to this batch container, not just the generic allocation row
        $alreadyOrdered = \App\Models\Order::where('user_id', auth()->id())
            ->whereHas('allocation', function ($query) use ($batch) {
                // Pinpoints this exact product category
                $query->where('allocation_batch_id', $batch->id); 
            })
            ->whereIn('status', ['pending', 'paid', 'collected'])
            ->sum('quantity');

        // THIS WILL HALT THE PAGE AND SHOW US THE RAW NUMBERS:
        // dd([
        //     'Current User ID' => auth()->id(),
        //     'Current Batch ID' => $batch->id,
        //     'Max Allowed Per User' => $batch->max_per_user,
        //     'Calculated Already Ordered Count' => $alreadyOrdered,
        //     'Is Limit Reached Block Triggered?' => ($batch->max_per_user - $alreadyOrdered) <= 0
        // ]);

        $remainingAllowance = $batch->max_per_user - $alreadyOrdered;

        return view('consumer.show', compact('batch', 'allocation', 'stateQuota', 'remainingAllowance', 'alreadyOrdered'));
    }

    public function storeOrder(Request $request) 
    {
        // 1. Validation
        $validated = $request->validate([
            'allocation_id' => 'required|exists:subsidized_allocations,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // 2. Fetch the Allocation and Batch Data
        $allocation = SubsidizedAllocation::with('batch')->findOrFail($validated['allocation_id']);
        $batch = $allocation->batch;

        // 1. Calculate how many units this user has already ordered for this product
        $alreadyOrdered = Order::where('user_id', auth()->id())
            ->where('allocation_id', $allocation->id)
            ->whereIn('status', ['pending', 'paid', 'collected']) // Count everything except failed/canceled
            ->sum('quantity');

        // 2. Determine remaining allowance for this specific user
        $remainingAllowance = $batch->max_per_user - $alreadyOrdered;

        // 3. Validation: Is the new request too much?
        if ($validated['quantity'] > $remainingAllowance) {
            return back()->with('error', "Limit exceeded. You have already ordered {$alreadyOrdered} units. Your remaining allowance is {$remainingAllowance}.");
        }

        // Security Checks (Business Logic)
        // Prevent user from ordering for a different state
        if ($allocation->state_name !== auth()->user()->state) {
            return back()->with('error', 'You can only claim subsidies for your registered state.');
        }
        

        // Check if enough stock remains
        if ($allocation->remaining_quota < $validated['quantity']) {
            return back()->with('error', 'Sorry, insufficient stock remaining in your state.');
        }

        // 4. Create the Order via Eloquent
        $order = Order::create([
            'user_id' => auth()->id(), // Securely get the logged-in user's ID
            'allocation_id' => $allocation->id,
            'quantity' => $validated['quantity'],
            'amount_paid' => $batch->subsidized_price * $validated['quantity'], // Calculate automatically
            'payment_reference' => 'PG-' . strtoupper(Str::random(12)), // Generate unique ref
            'status' => 'pending',
        ]);

        // 5. Redirect to Payment Page
        return redirect()->route('consumer.orders.pay', $order->id,)
            ->with('success', 'Order initiated! Please complete payment to secure your quota.');
    }

    public function payOrder(Order $order)
    {
        // Security: Ensure the user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Load the related batch info through the allocation
        $order->load('allocation.batch');

        return view('consumer.pay', compact('order'));
    }

    public function orders()
    {
        $orders = auth()->user()->orders()
            ->with('allocation.batch') // Pulls the batch name and pricing
            ->latest()
            ->paginate(10);

        return view('consumer.orders.index', compact('orders'));
    }

    // Paystack function to verify payment status and mint dynamic unique tracking tags

    public function verifyPayment(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return redirect()->route('consumer.dashboard')->with('error', 'No reference supplied.');
        }

        // 1. Fetch the Order first to ensure it exists before calling external APIs
        $order = Order::where('payment_reference', $reference)->firstOrFail();

        // If already verified previously, don't ping Paystack again
        if ($order->status === 'paid' || $order->status === 'collected') {
            return redirect()->route('consumer.orders.index')->with('success', 'Order has already been verified.');
        }

        // 2. Query Paystack API Validation Engine
        $url = "https://api.paystack.co/transaction/verify/" . rawurlencode($reference);
        
        $response = Http::withToken(config('services.paystack.secret_key'))
            ->get($url);

        $data = $response->json();

        if ($response->successful() && isset($data['data']['status']) && $data['data']['status'] === 'success') {
            try {
                DB::transaction(function () use ($order) {
                    // Update Order Status
                    $order->update(['status' => 'paid']);
                    
                    // 3. Deduct State Quota Balance
                    if ($order->allocation) {
                        $order->allocation->decrement('remaining_quota', $order->quantity);
                    }
                    
                    // 4. --- Dynamic Unique Tracking ID Engine ---
                    $rawName = explode(' ', $order->user->name)[0]; 
                    $buyerName = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $rawName)); 
                    $stateName = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $order->allocation->state_name ?? 'HQ'));
                    
                    // Incorporating Order ID eliminates unique key collisions entirely
                    $orderIdentifier = str_pad($order->id, 4, '0', STR_PAD_LEFT); 

                    for ($i = 1; $i <= $order->quantity; $i++) {
                        $paddedIndex = str_pad($i, 2, '0', STR_PAD_LEFT); 
                        
                        // Resulting Format Example: JOHN-KANO-0042-01
                        $uniqueTrackingId = "{$buyerName}-{$stateName}-{$orderIdentifier}-{$paddedIndex}";

                        $order->items()->create([
                            'item_tracking_id' => $uniqueTrackingId,
                            'status' => 'paid'
                        ]);
                    }
                });

                return redirect()->route('consumer.orders.index')->with('success', 'Payment successful! Your tracking codes are generated.');

            } catch (\Exception $e) {
                // Log full contextual details for tracking anomalies
                Log::error('Verification Redirect Database Transaction Failed', [
                    'reference' => $reference,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                // Flash the exact database engine error directly to the user during testing
                return redirect()->route('consumer.orders.index')->with('error', 'Sync Failed: ' . $e->getMessage());
            }
        }

        // 5. Handle Definite Payment Deficiencies
        $order->update(['status' => 'failed']);
        return redirect()->route('consumer.orders.index')->with('error', 'Payment verification failed or was declined by gateway.');
    }


    public function orderDetails(Order $order)
    {
        // Security: Only the owner can see their order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['allocation.batch', 'items']);
        return view('consumer.orders.details', compact('order'));
    }
}
