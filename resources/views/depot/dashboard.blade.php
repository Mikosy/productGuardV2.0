<x-depot.layout>
    <x-slot:title>Depot Command Center</x-slot:title>

    <div class="max-w-6xl mx-auto px-6 py-12">
        <header class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#52B788]/10 text-[#1B4332] text-[10px] font-black uppercase tracking-widest mb-4 border border-[#52B788]/20">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#52B788] opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-[#52B788]"></span>
                    </span>
                    Logistics Node: {{ $officerState }} State Facility
                </div>
                <h1 class="text-4xl font-black tracking-tight text-[#1B4332]">Depot Command Center</h1>
                <p class="text-gray-500 mt-2 text-lg">Acknowledge incoming macro stock and manage distribution paths.</p>
            </div>
            
            <div class="flex items-center flex-col gap-4">
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-end">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Local Time</span>
                    <span class="text-lg font-black text-[#1B4332]">{{ now()->format('H:i') }} <span class="text-sm font-medium text-gray-400">{{ now()->format('A') }}</span></span>
                </div>

                <a href="{{ route('depot.listOfUsersWhoPaid') }}" class="inline-flex w-full items-center justify-center px-4 py-3 text-xs font-black uppercase tracking-widest text-white bg-[#064E3B] hover:bg-black rounded-xl transition-all text-center">
                        Users Who Paid
                    </a>
            </div>
            
        </header>

        <div class="inventory-section">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-xs font-black text-[#1B4332] uppercase tracking-[0.2em] flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-[#52B788]"></span>
                        Assigned State Allocations
                    </h2>
                </div>

                <form action="{{ route('depot.dashboard') }}" method="GET" class="w-full md:w-80">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Batch Reference..." 
                            class="w-full pl-10 pr-4 py-3 text-xs border border-gray-200 rounded-2xl focus:outline-none focus:border-[#1B4332] bg-white transition-colors">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 text-xs">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50">
                                @foreach(['Product Cargo', 'Total Allocation', 'Remaining Quota', 'Warehouse Status', 'View Items', 'Orders List'] as $header)
                                    @if($header === 'Orders List')
                                        {{-- Only show 'Orders List' if a condition is met --}}
                                        @if($allocations->contains('status', 'received'))
                                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $header }}</th>
                                        @endif
                                    @elseif($header === 'View Items')
                                        {{-- Only show 'View Items' if a condition is met --}}
                                        @if($allocations->contains('status', 'received'))
                                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $header }}</th>
                                        @else
                                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Confirm Batch Arrival</th>
                                        @endif
                                    @else
                                        {{-- Show all other headers normally --}}
                                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $header }}</th>
                                    @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($allocations as $allocation)
                                <tr class="hover:bg-gray-50/80 transition-all group">
                                    
                                    <td class="px-8 py-6">
                                        <span class="text-sm font-black text-gray-800">{{ $allocation->batch->product_name }}</span>
                                    </td>

                                    <td class="px-8 py-6">
                                        <span class="text-sm font-bold text-gray-600">{{ number_format($allocation->state_quota) }} Units</span>
                                    </td>

                                    <td class="px-8 py-6">
                                        <span class="text-sm font-black text-[#1B4332]">{{ number_format($allocation->remaining_quota) }} left</span>
                                    </td>

                                    <td class="px-8 py-6">
                                        @if(($allocation->status ?? 'pending') === 'received')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border bg-green-50 text-green-600 border-green-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Received
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border bg-amber-50 text-amber-600 border-amber-100 animate-pulse">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> In Transit
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-8 py-6 items-center gap-2">
                                        @if(($allocation->status ?? 'pending') !== 'received')
                                            <form action="{{ route('depot.allocation.arrive', $allocation->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-xl bg-amber-500 text-white hover:bg-[#1B4332] transition-all shadow-sm">
                                                    Confirm Arrival
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('depot.intake.index', ['allocation_id' => $allocation->id]) }}" 
                                            class="inline-flex items-center justify-center px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-xl bg-gray-50 text-gray-500 hover:bg-[#1B4332] hover:text-white transition-all shadow-sm">
                                                Manage Intake
                                            </a>
                                        @endif
                                    </td>

                                    <td class="px-8 py-6 items-center">
                                        @if(($allocation->status ?? 'pending') === 'received')
                                            <a href="{{ route('depot.allocation.orders', $allocation->id) }}" 
                                            class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gray-50 text-gray-400 hover:bg-black hover:text-white transition-all shadow-sm" title="View Orders">
                                                <i class="fa-solid fa-users text-xs"></i>
                                            </a>
                                        @else
                                            <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest selection:bg-none">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-20 bg-white">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fa-solid fa-truck text-gray-300 text-xl"></i>
                                        </div>
                                        <h3 class="text-sm font-black text-[#1B4332]">No Allocations Appointed</h3>
                                        <p class="text-xs text-gray-400 max-w-xs mx-auto mt-1 font-medium">No logistical cargo streams are mapped to your field position currently.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8">
                {{ $allocations->links() }}
            </div>
        </div>
    </div>
</x-depot.layout>