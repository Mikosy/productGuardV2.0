<x-depot.layout> 
    <div class="max-w-3xl mx-auto py-12 px-4">
        
        <nav class="mb-8 no-print">
            <a href="{{ route('depot.listOfUsersWhoPaid') }}" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-[#064E3B] transition-colors">
                ← Back to Order Console
            </a>
        </nav>

        <div class="bg-white border border-gray-100 rounded-3xl p-8 shadow-xl relative overflow-hidden">
            
            <div class="flex justify-between items-start border-b border-gray-100 pb-6 mb-6">
                <div>
                    <span class="px-2.5 py-1 bg-emerald-100 text-[#064E3B] text-[9px] font-black uppercase rounded tracking-wider">
                        Payment Authenticated
                    </span>
                    <h2 class="text-2xl font-black text-gray-900 mt-2">Subsidy Allocation Receipt</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Ref Reference ID: <span class="font-mono font-bold text-gray-700">{{ $order->payment_reference }}</span></p>
                </div>
                
                <button onclick="window.print()" class="no-print px-4 py-2 bg-gray-100 hover:bg-black hover:text-white text-xs font-black uppercase tracking-widest rounded-xl transition-all">
                    Print Receipt
                </button>
            </div>

            <div class="grid grid-cols-2 gap-6 text-sm mb-8">
                <div>
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Citizen Details</h4>
                    <p class="font-bold text-gray-800 mt-1">{{ $order->user->name }}</p>
                    <p class="text-xs text-gray-500 font-mono">{{ $order->user->email }}</p>
                </div>
                <div class="text-right">
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Distribution Node</h4>
                    <p class="font-bold text-gray-800 mt-1">{{ $order->allocation->state_name ?? 'N/A' }} State Depot</p>
                    <p class="text-xs text-gray-400">Date: {{ $order->created_at->format('M d, Y @ h:i A') }}</p>
                </div>
            </div>

            <div class="bg-gray-50 rounded-2xl p-6 mb-6">
                <div class="flex justify-between items-center border-b border-gray-200/60 pb-4">
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase">Allocated Inventory Item</p>
                        <p class="text-lg font-black text-gray-900 mt-0.5">{{ $order->allocation->batch->product_name ?? 'Subsidized Unit' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-400 font-bold uppercase">Volume</p>
                        <p class="text-xl font-black text-[#064E3B] mt-0.5">x{{ $order->quantity }}</p>
                    </div>
                </div>
                <div class="flex justify-between items-center pt-4">
                    <span class="text-xs text-gray-500 font-bold">Total Transacted Remittance</span>
                    <span class="text-lg font-black text-gray-900">₦{{ number_format($order->amount_paid, 2) }}</span>
                </div>
            </div>

            <div>
                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-wider mb-3">Individual Serial Key Identification Codes</h4>
                <div class="space-y-2">
                    @forelse($order->items as $item)
                        <div class="flex items-center justify-between border border-gray-100 rounded-xl p-3 bg-white hover:bg-gray-50 transition-colors">
                            <span class="font-mono text-sm font-bold text-gray-800">{{ $item->item_tracking_id }}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider {{ $item->status === 'collected' ? 'bg-gray-100 text-gray-500' : 'bg-green-100 text-green-800' }}">
                                {{ $item->status }}
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-amber-600 bg-amber-50 rounded-xl p-3 border border-amber-100 font-medium">
                            Warning: Secure specific physical cargo serial trackers have not been provisioned for this transactional reference yet.
                        </p>
                    @endforelse
                </div>
            </div>

            <p class="text-[9px] text-center text-gray-400 mt-12 block select-none">
                Secured Infrastructure Audit Manifest via ProductGuard v2.0
            </p>
        </div>
    </div>
</x-depot.layout> 