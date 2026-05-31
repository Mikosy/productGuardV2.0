<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubsidizedAllocation;
use Illuminate\Http\Request;

use Illuminate\Pagination\Paginator;
use App\Models\AllocationBatch;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Order;
use App\Models\OrderItem;



class AllocationController extends Controller
{
    /**
     * Show the form to create a new Federal Allocation.
     */
    public function create()
    {
        $states = [
            'Abia', 'Adamawa', 'Akwa Ibom', 'Anambra', 'Bauchi', 'Bayelsa', 'Benue', 'Borno', 
            'Cross River', 'Delta', 'Ebonyi', 'Edo', 'Ekiti', 'Enugu', 'FCT', 'Gombe', 
            'Imo', 'Jigawa', 'Kaduna', 'Kano', 'Katsina', 'Kebbi', 'Kogi', 'Kwara', 
            'Lagos', 'Nasarawa', 'Niger', 'Ogun', 'Ondo', 'Osun', 'Oyo', 'Plateau', 
            'Rivers', 'Sokoto', 'Taraba', 'Yobe', 'Zamfara'
        ];

        return view('admin.allocations.create', compact('states'));
    }

    /**
     * Store the Federal News and State Quotas in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string',
            'total_quantity' => 'required|integer',
            'news_source' => 'nullable|url',
            'market_price' => 'required|numeric',
            'subsidized_price' => 'required|numeric',
            'max_per_user' => 'required|integer',
            'quotas' => 'required|array',
        ]);

        // 1. Create the Parent first
        $batch = AllocationBatch::create([
            'product_name' => $request->product_name,
            'total_quantity' => $request->total_quantity,
            'news_source' => $request->news_source,
            'market_price' => $request->market_price,
            'subsidized_price' => $request->subsidized_price,
            'max_per_user' => $request->max_per_user,
        ]);

        // 2. Create the Child Records linked to this Batch
        foreach ($validated['quotas'] as $state => $amount) {
            if ($amount > 0) {
                $batch->subsidizedAllocations()->create([
                    'state_name' => $state,
                    'state_quota' => $amount,
                    'remaining_quota' => $amount,
                ]);
            }
        }
        return redirect()->route('admin.allocations.index')
            ->with('success', 'Federal allocation batch minted and state quotas deployed successfully.');
    }

    public function index()
    {
        // Now pagination shows "1 to 3 of 3 results" instead of 111!
        $batches = AllocationBatch::orderBy('created_at', 'desc')->paginate(10);


        return view('admin.allocations.index', compact('batches'));
    }

    public function show(AllocationBatch $batch)
    {
        // Eager load the allocations to keep the page fast
        $allocations = $batch->subsidizedAllocations()->orderBy('state_name', 'asc')->get();

        return view('admin.allocations.show', compact('batch', 'allocations'));
    }

    public function destroy(AllocationBatch $batch)
    {
        // This will delete the parent batch. 
        // If your migration has onDelete('cascade'), it cleans up child state rows automatically!
        $batch->delete();

        return redirect()->route('admin.allocations.index')
            ->with('success', 'Allocation batch removed from system metrics successfully.');
    }

    /**
     * Display states with counts of paid, undispatched order items
     */
    public function dispatchStates()
    {
        // Fetch only items that are 'paid' (meaning not yet 'collected' or 'damaged')
        // We group them dynamically based on the allocation state_name
        $stateGroups = OrderItem::whereIn('status', ['paid', 'damaged'])
            ->with('order.allocation')
            ->get()
            ->groupBy(function($item) {
                return $item->order->allocation->state_name ?? 'Unassigned';
            });

        return view('admin.dispatch.index', compact('stateGroups'));
    }

    /**
     * Review all printable tags for a targeted state group
     */
    public function dispatchStateOrders($state)
    {
        // Fetch every individual paid order item assigned to this region
        $items = OrderItem::whereIn('status', ['paid', 'damaged'])
            ->whereHas('order.allocation', function($query) use ($state) {
                $query->where('state_name', $state);
            })
            ->with(['order.user', 'order.allocation.batch'])
            ->get();

        return view('admin.dispatch.show', compact('items', 'state'));
    }
}