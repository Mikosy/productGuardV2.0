<x-admin.layout>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Global Payments Registry</h1>
            <p class="text-sm text-gray-500 mt-1">Central audit console tracking verified paid orders across all regional deployment depots.</p>
        </div>

        <div class="bg-white rounded-3xl p-4 border border-gray-100 shadow-sm mb-6">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                
                <div class="flex-grow">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search globally by reference, citizen name, or email..." 
                           class="w-full pl-5 pr-5 py-3.5 bg-gray-50 border-none rounded-2xl font-medium text-sm focus:ring-2 focus:ring-[#1B4332] transition-all"
                    >
                </div>

                <div class="md:w-64">
                    <select name="state" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl font-medium text-sm focus:ring-2 focus:ring-[#1B4332] transition-all text-gray-600">
                        <option value="">All States / Depots</option>
                        @foreach($allStates as $state)
                            <option value="{{ $state }}" {{ request('state') === $state ? 'selected' : '' }}>
                                {{ strtoupper($state) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="px-6 py-3.5 bg-[#1B4332] text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-black transition-all">
                        Filter Records
                    </button>
                    @if(request('search') || request('state'))
                        <a href="{{ route('admin.orders.index') }}" class="px-4 py-3.5 bg-gray-100 text-gray-500 text-xs font-bold uppercase tracking-widest rounded-2xl hover:bg-gray-200 transition-all flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-left">
                    <thead class="bg-gray-50/70 text-[10px] font-black uppercase text-gray-400 tracking-widest">
                        <tr>
                            <th class="px-6 py-4">Transaction Reference</th>
                            <th class="px-6 py-4">Beneficiary</th>
                            <th class="px-6 py-4">Target Region Depot</th>
                            <th class="px-6 py-4">Allocated Product</th>
                            <th class="px-6 py-4 text-center">Volume</th>
                            <th class="px-6 py-4 text-right">Audit Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm font-medium text-gray-700">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 font-mono text-xs text-[#1B4332] font-bold">
                                    {{ $order->payment_reference }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $order->user->name }}</div>
                                    <div class="text-[10px] text-gray-400 font-mono">{{ $order->user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 font-bold uppercase text-gray-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        {{ $order->allocation->state_name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $order->allocation->batch->product_name ?? 'Subsidized Cargo' }}
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-gray-900">
                                    {{ $order->quantity }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-50 hover:bg-[#1B4332] hover:text-white text-gray-700 text-xs font-black uppercase tracking-wider rounded-xl transition-all">
                                        Audit Order
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                                    <p class="text-base font-bold">No verified global transactions found matching filters</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin.layout>