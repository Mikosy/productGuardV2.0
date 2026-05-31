<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\SubsidizedAllocation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;




class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Total Items Minted (All serial key tracking records)
        $totalItemsMinted = OrderItem::count();
        
        // Items minted today (created within the last 24 hours)
        $itemsMintedToday = OrderItem::where('created_at', '>=', Carbon::today())->count();

        // 2. Active Batches & Territorial States
        // Get unique state names currently running allocations
        $activeStatesList = SubsidizedAllocation::distinct()->pluck('state_name')->toArray();
        $totalActiveStates = count($activeStatesList);
        
        // Count distinct allocation packages
        $totalActiveBatches = SubsidizedAllocation::distinct('allocation_batch_id')->count();

        // 3. System Integrity Feedbacks & Critical Fault Trackers
        // Paid/Collected orders represent flawless flow integrations
        $goodFeedbackCount = OrderItem::whereIn('status', ['paid', 'collected'])->count();
        
        // Critical alerts mapping directly to your 'damaged' items flag from earlier
        $criticalAlertsCount = OrderItem::where('status', 'damaged')->count();

        // Fetch both total and remaining quotas aggregated by state region
        $stateQuotaMetrics = SubsidizedAllocation::select(
                'state_name',
                DB::raw('SUM(state_quota) as total_allocated'),
                DB::raw('SUM(remaining_quota) as total_remaining')
            )
            ->groupBy('state_name')
            ->get();

        $chartLabels = [];
        $chartValues = [];

        foreach ($stateQuotaMetrics as $metric) {
            $chartLabels[] = $metric->state_name;
            
            $allocated = (float) $metric->total_allocated;
            $remaining = (float) $metric->total_remaining;
            
            // Calculate how much has been ordered/purchased
            $orderedAmount = $allocated - $remaining;

            // Prevent dividing by zero if an allocation was misconfigured with a 0 quota
            if ($allocated > 0) {
                // Calculate utilization percentage (e.g., if 30 out of 100 are ordered, this equals 30%)
                $utilizationPercentage = round(($orderedAmount / $allocated) * 100, 1);
            } else {
                $utilizationPercentage = 0;
            }

            $chartValues[] = $utilizationPercentage;
        }

        return view('admin.dashboard', compact(
            'totalItemsMinted',
            'itemsMintedToday',
            'totalActiveBatches',
            'totalActiveStates',
            'activeStatesList',
            'goodFeedbackCount',
            'criticalAlertsCount',
            'chartLabels',
            'chartValues'
        ));
    }

    /**
     * Display a global ledger of all verified, paid orders across all states.
     */
    public function globalOrdersIndex(Request $request)
    {
        $search = $request->input('search');
        $stateFilter = $request->input('state');

        $query = Order::where('status', 'paid')
            ->with(['user', 'allocation.batch']);

        // Filter by State if a specific region is selected from the dropdown
        if ($stateFilter) {
            $query->whereHas('allocation', function ($q) use ($stateFilter) {
                $q->where('state_name', $stateFilter);
            });
        }

        // Search by Reference Number, Name, or Email
        if ($search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('payment_reference', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                    });
            });
        }

        $orders = $query->latest()->paginate(15);
        
        // Get all unique active states to populate the Admin's dropdown filter list
        $allStates = SubsidizedAllocation::distinct()->pluck('state_name');

        return view('admin.orders.index', compact('orders', 'allStates'));
    }

    /**
     * Display an exhaustive administrative audit log for a specific order.
     */
    public function globalOrderShow(Order $order)
    {
        // Eager load everything needed for an executive audit trail
        $order->load(['user', 'allocation.batch', 'items']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Display all items reported as damaged across the ecosystem.
     */
    public function globalIncidentsIndex()
    {
        // Fetch all item codes flagged as damaged along with their parent orders
        $damagedItems = OrderItem::where('status', 'damaged')
            ->with(['order.user', 'order.allocation.batch'])
            ->latest()
            ->paginate(15);

        return view('admin.incidents.index', compact('damagedItems'));
    }

    /**
     * Process administrative resolutions for damaged physical cargo stock items.
     */
    public function resolveIncident(Request $request, OrderItem $item)
    {
        $request->validate([
            'action' => 'required|in:replace_and_reissue,refund_quota'
        ]);

        $order = $item->order;
        $allocation = $order->allocation;

        if ($request->input('action') === 'replace_and_reissue') {
            // ACTION A: Re-mint a fresh, secure Tracking ID for the citizen to collect.
            $newItemTrackingId = 'PG2-' . strtoupper(Str::random(4)) . '-' . rand(1000, 9999);
            
            OrderItem::create([
                'order_id' => $order->id,
                'item_tracking_id' => $newItemTrackingId,
                'status' => 'paid', // Ready for pickup again at the local depot
            ]);

            // Permanently move the damaged row out of the primary live feed queue
            $item->update(['status' => 'archived_damaged']);

        } elseif ($request->input('action') === 'refund_quota') {
            // ACTION B: Cancel this single unit item and return 1 unit back to the State pool.
            $allocation->increment('remaining_quota', 1);
            
            // Mark the tracking item row status as voided
            $item->update(['status' => 'voided_damaged']);
            
            // Optional: Run custom application logic here to initiate an accounting refund process.
        }

        return redirect()->back()->with('success', 'Incident resolved and inventory parameters synchronized.');
    }
}