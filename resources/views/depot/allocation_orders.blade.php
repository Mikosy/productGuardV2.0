<x-depot.layout>
    <x-slot:title>Allocation Consumer Orders</x-slot:title>

    <div class="max-w-6xl mx-auto px-6 py-12">
        <div class="mb-6">
            <a href="{{ route('depot.dashboard') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-black transition-colors">← Back to Allocations</a>
        </div>

        <header class="mb-12">
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Tier 2 Breakdown</p>
            <h1 class="text-3xl font-black text-[#1B4332] mt-1">Paid Claims for {{ $allocation->batch->product_name }}</h1>
            <p class="text-gray-500 text-sm mt-1">Batch ID: <span class="font-mono font-bold">{{ $allocation->batch->batch_number }}</span></p>
        </header>

        <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50">
                            @foreach(['Payment reference', 'Claimant Name', 'Quantity Ordered', 'Log Status', 'Actions'] as $header)
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50/80 transition-all">
                                <td class="px-8 py-6 font-mono text-xs font-bold text-gray-900 uppercase">{{ $order->payment_reference }}</td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-gray-800">{{ $order->user->name }}</span>
                                        <span class="text-[10px] text-gray-400 font-medium">{{ $order->user->email }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-sm font-black text-[#1B4332]">{{ number_format($order->quantity) }} Units</td>
                                <td class="px-8 py-6">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border bg-green-50 text-green-600 border-green-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <a href="{{ route('depot.order.items', $order->id) }}" 
                                       class="inline-flex items-center justify-center px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-xl bg-gray-50 text-gray-500 hover:bg-[#1B4332] hover:text-white transition-all shadow-sm">
                                        Inspect Items →
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-16 text-gray-400 text-xs font-medium">
                                    No consumer claims have completed processing against this allocation node yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</x-depot.layout>