<x-depot.layout>
    <x-slot:title>Secure Verification Tokens</x-slot:title>

    <div class="max-w-4xl mx-auto px-6 py-12">
        <div class="mb-6">
            <a href="{{ route('depot.allocation.orders', $order->allocation_id) }}" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-black transition-colors">← Back to Orders</a>
        </div>

        <header class="mb-10 p-8 bg-gray-50 rounded-[2rem] border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <p class="text-[9px] font-black uppercase tracking-widest text-gray-400">Order Context Node</p>
                <h1 class="text-2xl font-black text-[#1B4332] tracking-tight mt-0.5">{{ $order->user->name }}</h1>
                <p class="text-xs text-gray-400 mt-1">Reference: <span class="font-mono font-bold uppercase text-gray-600">{{ $order->payment_reference }}</span></p>
            </div>
            <div class="text-left sm:text-right">
                <p class="text-[9px] font-black uppercase tracking-widest text-gray-400">Volume Cargo</p>
                <p class="text-xl font-black text-[#1B4332] mt-0.5">{{ $order->items->count() }} Sub-Units</p>
            </div>
        </header>

        <div class="space-y-3">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Individual Verification Tokens</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($order->items as $item)
                    <div class="group flex items-center justify-between p-4 bg-white border border-gray-100 rounded-2xl shadow-sm hover:border-[#1B4332] transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center text-gray-400 group-hover:text-[#1B4332] transition-colors">
                                <i class="fa-solid fa-qrcode text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs font-black font-mono text-gray-900 tracking-tight">{{ $item->item_tracking_id }}</p>
                                <p class="text-[9px] font-medium text-gray-400 uppercase tracking-wider mt-0.5">Secure Logistical Unit</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 text-[8px] font-black uppercase tracking-widest rounded border 
                                {{ $item->status === 'collected' ? 'bg-blue-50 text-blue-700 border-blue-100' : '' }}
                                {{ $item->status === 'paid' ? 'bg-green-50 text-green-700 border-green-100' : '' }}
                                {{ $item->status === 'damaged' ? 'bg-red-50 text-red-700 border-red-100' : '' }}">
                                {{ $item->status }}
                            </span>

                            @if($item->status === 'paid')
                                <form action="{{ route('depot.verify.collect') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-gray-50 text-gray-400 hover:bg-[#1B4332] hover:text-white flex items-center justify-center transition-all shadow-sm" title="Mark Dispatched">
                                        <i class="fa-solid fa-check text-xs"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-depot.layout>