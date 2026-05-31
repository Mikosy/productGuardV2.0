<x-consumer.layout>

    

    <div class="max-w-6xl mx-auto py-10 px-4">
        <header class="mb-10">
            <a href="{{ route('consumer.dashboard') }}" class="block  mt-4 mb-6 text-sm text-gray-400 font-medium">
                <i class="fas fa-arrow-left"></i>
                Back home
            </a>
            <h1 class="text-3xl font-black text-gray-900">My Subsidy Claims</h1>
            <p class="text-gray-500">Track your order status and collection progress.</p>
        </header>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-gray-400 tracking-widest">Order Ref</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-gray-400 tracking-widest">Product</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-gray-400 tracking-widest text-center">Qty</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-gray-400 tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-gray-400 tracking-widest text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                        <tr>
                            <td class="px-6 py-4 font-mono text-sm text-[#064E3B]">{{ $order->payment_reference }}</td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-900">{{ $order->allocation->batch->product_name }}</p>
                                <p class="text-xs text-gray-400">{{ $order->created_at->format('M d, Y') }}</p>
                            </td>
                            <td class="px-6 py-4 text-center font-medium">{{ $order->quantity }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'paid' => 'bg-green-100 text-green-700',
                                            'failed' => 'bg-red-100 text-red-700',
                                            'collected' => 'bg-blue-100 text-blue-700',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $statusClasses[$order->status] ?? 'bg-gray-100' }}">
                                        {{ $order->status }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($order->status === 'pending')
                                    <a href="{{ route('consumer.orders.pay', $order->id) }}" class="text-xs font-black text-[#064E3B] hover:underline">
                                        Complete Payment →
                                    </a>
                                @else
                                    <a href="{{ route('consumer.orders.details', $order->id) }}" class="text-xs text-gray-400 italic font-medium text-center hover:underline">View details</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-gray-400 italic">
                                You haven't made any claims yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</x-consumer.layout>
