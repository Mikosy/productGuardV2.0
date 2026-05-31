<?php

namespace App\Http\Controllers\Depot_Officer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SubsidizedAllocation;
use Illuminate\Http\Request;
use App\Models\User;

class DepotofficerController extends Controller
{
    /**
     * Tier 1: State Allocations Dashboard
     */
    public function dashboard(Request $request)
    {
        $officerState = auth()->user()->state;
        $search = $request->input('search');

       $allocations = SubsidizedAllocation::where('state_name', $officerState)
        ->when($search, function ($query) use ($search) {
            $query->whereHas('batch', function ($b) use ($search) {
                // Group the OR parameters securely inside a sub-query
                $b->where(function ($subQuery) use ($search) {
                    $subQuery->where('id', 'LIKE', "%{$search}%")
                            ->orWhere('product_name', 'LIKE', "%{$search}%");
                });
            });
        })
        ->with(['batch'])
        ->latest()
        ->paginate(10);

        return view('depot.dashboard', compact('allocations', 'officerState'));
    }

    /**
     * Tier 2: Display individual consumer orders placed against a specific allocation block.
     */
    public function allocationOrders(SubsidizedAllocation $allocation)
    {
        // Security check: Guard access boundaries
        if ($allocation->state_name !== auth()->user()->state) { 
            abort(403); 
        }

        $orders = Order::where('allocation_id', $allocation->id)
            ->where('status', 'paid')
            ->with('user')
            ->latest()
            ->paginate(15);

        return view('depot.allocation_orders', compact('allocation', 'orders'));
    }

    /**
     * Flip the allocation status from 'pending' (In Transit) to 'received' (Arrived)
     */
    public function confirmArrival(SubsidizedAllocation $allocation)
    {
        // Security check: Guard state boundaries
        if ($allocation->state_name !== auth()->user()->state) { 
            abort(403); 
        }

        // Update allocation status to 'received'
        $allocation->status = 'received';
        $allocation->save();

        return redirect()->back()->with('success', 'Bulk allocation arrival logged. Inventory status updated to Arrived.');
    }

    /**
     * Tier 3: Show individual units inside an order for verification dispatching
     */
    public function orderItemsList(Order $order)
    {
        if ($order->allocation->state_name !== auth()->user()->state) { 
            abort(403); 
        }

        $order->load(['items', 'user']);
        return view('depot.order_items', compact('order'));
    }

    /**
     * Intake: View state items to verify condition before release.
     */
    public function intakeList(Request $request)
    {
        // Fallback to empty collection if intake layout file isn't populated yet
        $officerState = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', auth()->user()->state));
        $search = $request->input('search');

        $items = OrderItem::where('item_tracking_id', 'LIKE', "%-{$officerState}-%")
            ->when($search, function($query) use ($search) {
                $query->where('item_tracking_id', 'LIKE', "%{$search}%");
            })
            ->latest()
            ->paginate(20);

        return view('depot.intake', compact('items'));
    }

    /**
     * Handle Item Status Update (Acknowledge Receipt / Collection Handover)
     */
    public function processCollection(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:order_items,id'
        ]);

        $item = OrderItem::findOrFail($request->item_id);

        // CHANGED: Switching 'received' to 'collected' to satisfy the database check constraint
        $item->status = 'collected'; 
        $item->save();

        return redirect()->back()->with('success', 'Item tracking status acknowledged successfully.');
    }

    /**
     * Handle Cargo Damage Logging with Live Image Proof Upload
     */
    public function flagDamage(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // Max 5MB limit
        ]);

        $item = OrderItem::findOrFail($id);
        
        // Process the live proof image upload
        if ($request->hasFile('proof_image')) {
            // Saves file to storage/app/public/damage_proofs
            $path = $request->file('proof_image')->store('damage_proofs', 'public');
        }

        // Update item record properties matching your exact DB schema columns
        $item->status = 'damaged';
        $item->damage_notes = $request->notes;
        $item->damage_proof_image = $path ?? null; // <-- Changed from damage_proof_path to damage_proof_image
        
        $item->save();

        return redirect()->back()->with('success', 'Damage log updated with live proof attachments.');
    }

    
    public function listOfUsersWhoPaid(Request $request)
    {
        $officerState = auth()->user()->state;
        $search = $request->input('search');

        $orders = Order::where('status', 'paid') // Filter for orders that have cleared payment
            ->whereHas('allocation', function ($query) use ($officerState) {
                $query->where('state_name', $officerState); // Lock downstream parameters to officer's state
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    // Search details via the payment reference string directly...
                    $subQuery->where('payment_reference', 'LIKE', "%{$search}%")
                        // ...or traverse the user relation to look up by name/email
                        ->orWhereHas('user', function ($u) use ($search) {
                            $u->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->with(['user', 'allocation.batch']) // Eager load relations to save query cost
            ->latest()
            ->paginate(10);

        return view('depot.list_of_users_who_paid', compact('orders'));
    }

    /**
     * Display secure order metadata & receipt layout for verification processing.
     */
    public function showOrderReceipt(Order $order)
    {
        $officerState = auth()->user()->state;

        // Security Gate: Ensure this order actually belongs to the Depot Officer's domain
        $order->load(['allocation', 'user', 'items']);
        
        if (($order->allocation->state_name ?? '') !== $officerState) {
            abort(403, 'Unauthorized access to regional order resources.');
        }

        return view('depot.order_receipt', compact('order'));
    }
}