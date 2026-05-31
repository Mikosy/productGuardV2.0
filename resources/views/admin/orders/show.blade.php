<x-admin.layout>
    <div class="max-w-4xl mx-auto py-12 px-4">
        
        <nav class="mb-8">
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-[#1B4332] transition-colors">
                ← Back to Global Ledger
            </a>
        </nav>

        <div class="bg-white border border-gray-100 rounded-3xl p-8 shadow-xl relative overflow-hidden">
            
            <div class="flex justify-between items-start border-b border-gray-100 pb-6 mb-6">
                <div>
                    <span class="px-2.5 py-1 bg-emerald-100 text-[#1B4332] text-[9px] font-black uppercase rounded tracking-wider">
                        Ecosystem Audit Approved
                    </span>
                    <h2 class="text-2xl font-black text-gray-900 mt-2">Administrative Transaction Profile</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Reference ID: <span class="font-mono font-bold text-gray-700">{{ $order->payment_reference }}</span></p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm mb-8 bg-gray-50 rounded-2xl p-6">
                <div>
                    <h4 class="text-[9px] font-black text-gray-400 uppercase tracking-wider">Citizen / Buyer</h4>
                    <p class="font-bold text-gray-800 mt-1">{{ $order->user->name }}</p>
                    <p class="text-xs text-gray-500 font-mono mt-0.5">{{ $order->user->email }}</p>
                </div>
                <div>
                    <h4 class="text-[9px] font-black text-gray-400 uppercase tracking-wider">Assigned Destination Depot</h4>
                    <p class="font-bold text-gray-800 mt-1 uppercase">{{ $order->allocation->state_name ?? 'N/A' }} State Warehouse</p>
                    <p class="text-xs text-gray-400 mt-0.5">Batch Allocation #{{ $order->allocation_id }}</p>
                </div>
                <div>
                    <h4 class="text-[9px] font-black text-gray-400 uppercase tracking-wider">Financial Breakdown</h4>
                    <p class="font-black text-[#1B4332] text-base mt-0.5">₦{{ number_format($order->amount_paid, 2) }}</p>
                    <p class="text-[11px] text-gray-400 font-bold">Volume: {{ $order->quantity }} Units Purchased</p>
                </div>
            </div>

            <div>
                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-wider mb-3">Minted Serial Tracking Codes Manifest</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @forelse($order->items as $item)
                        <div class="flex items-center justify-between border border-gray-100 rounded-xl p-3.5 bg-white hover:bg-gray-50 transition-colors">
                            <span class="font-mono text-sm font-bold text-gray-800">{{ $item->item_tracking_id }}</span>
                            <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider {{ $item->status === 'collected' ? 'bg-gray-100 text-gray-500' : 'bg-emerald-100 text-emerald-800' }}">
                                {{ $item->status }}
                            </span>
                        </div>
                    @empty
                        <div class="col-span-full p-4 text-center text-xs text-amber-600 bg-amber-50 rounded-xl border border-amber-100 font-medium">
                            No individual serial tracing codes have been initialized for this transactional reference context yet.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="border-t border-gray-100 mt-12 pt-4 flex justify-between items-center text-[10px] text-gray-400 font-mono font-medium">
                <span>System Registered: {{ $order->created_at->format('Y-m-d H:i:s') }}</span>
                <span>ProductGuard Security Network v2.0</span>
            </div>
        </div>
    </div>
</x-admin.layout>