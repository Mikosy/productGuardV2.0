<x-depot.layout> 
    <div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

        <div class="mb-4">
            
            <a href="{{ route('depot.dashboard') }}" class="text-[#064E3B] font-bold"><i class="fa-solid fa-arrow-left text-small mr-2"></i>Back</a>
        </div>
        
        <div class="mb-8">
            <span class="px-2.5 py-1 bg-emerald-50 text-[#064E3B] text-[10px] font-black uppercase rounded-md tracking-wider">
                Depot Registry: {{ auth()->user()->state }} State
            </span>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight mt-2">Incoming Paid Orders</h1>
            <p class="text-sm text-gray-500 mt-1">Manage processing cargo allocations, check payment references, and review verification receipts.</p>
        </div>

        <div class="bg-white rounded-3xl p-4 border border-gray-100 shadow-sm mb-6">
            <form action="{{ route('depot.listOfUsersWhoPaid') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Filter by Ref Number, Citizen Name, or Email..." 
                       class="w-full pl-5 pr-5 py-3.5 bg-gray-50 border-none rounded-2xl font-medium text-sm focus:ring-2 focus:ring-[#064E3B] transition-all"
                >
                <button type="submit" class="px-6 py-3.5 bg-[#064E3B] text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-black transition-all">
                    Search
                </button>
            </form>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden">
            <table class="min-w-full divide-y divide-gray-100 text-left">
                <thead class="bg-gray-50/70 text-[10px] font-black uppercase text-gray-400 tracking-widest">
                    <tr>
                        <th class="px-6 py-4">Order Ref</th>
                        <th class="px-6 py-4">Beneficiary</th>
                        <th class="px-6 py-4">Allocated Product</th>
                        <th class="px-6 py-4 text-center">Qty</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm font-medium text-gray-700">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-mono text-xs text-[#064E3B] font-bold">
                                {{ $order->payment_reference }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $order->user->name }}</div>
                                <div class="text-[10px] text-gray-400">{{ $order->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $order->allocation->batch->product_name ?? 'Subsidized Cargo' }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold">
                                {{ $order->quantity }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('depot.orders.receipt', $order->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-[#064E3B] hover:text-white text-gray-700 text-xs font-black uppercase tracking-wider rounded-xl transition-all">
                                    View Receipt →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-gray-400">No matching distribution orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</x-depot.layout>
