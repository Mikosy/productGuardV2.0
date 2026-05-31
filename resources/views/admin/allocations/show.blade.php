<x-admin.layout>
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <a href="{{ route('admin.allocations.index') }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-ferti-green transition-colors mb-4 group">
                <i class="fa-solid fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                Back to National List
            </a>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">
                {{ $batch->product_name }} <span class="text-gray-400 font-medium">Distribution</span>
            </h1>
            <p class="text-gray-500 mt-1 italic">Tracking resource availability across all participating states.</p>
        </div>
        
        <div class="flex gap-3">
             <div class="bg-white px-6 py-3 rounded-2xl border border-gray-100 shadow-sm">
                <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1">Total National Quota</p>
                <p class="text-xl font-black text-gray-900">{{ number_format($batch->total_quantity) }} <span class="text-xs font-medium text-gray-500 ml-1">Units</span></p>
             </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm">
            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-4">
                <i class="fa-solid fa-map-location-dot text-xl"></i>
            </div>
            <p class="text-sm font-bold text-gray-500">States Covered</p>
            <p class="text-2xl font-black text-gray-900">{{ $allocations->count() }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm">
            <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 mb-4">
                <i class="fa-solid fa-check-double text-xl"></i>
            </div>
            <p class="text-sm font-bold text-gray-500">Total Distributed</p>
            <p class="text-2xl font-black text-gray-900">{{ number_format($allocations->sum('state_quota')) }}</p>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm">
            <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 mb-4">
                <i class="fa-solid fa-warehouse text-xl"></i>
            </div>
            <p class="text-sm font-bold text-gray-500">Remaining Stock</p>
            <p class="text-2xl font-black text-gray-900">{{ number_format($allocations->sum('remaining_quota')) }}</p>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
            <h3 class="font-bold text-gray-900">State Breakdown</h3>
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" placeholder="Filter states..." class="pl-9 pr-4 py-2 bg-white border-gray-200 rounded-xl text-xs focus:ring-ferti-green focus:border-ferti-green w-64">
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white">
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-gray-400 tracking-widest">State</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-gray-400 tracking-widest">Total Quota</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-gray-400 tracking-widest">Remaining</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-gray-400 tracking-widest">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-gray-400 tracking-widest">Availability Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($allocations as $allocation)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center mr-3 text-[10px] font-bold text-gray-500 group-hover:bg-ferti-green group-hover:text-white transition-colors">
                                    {{ substr($allocation->state_name, 0, 2) }}
                                </div>
                                <span class="font-bold text-gray-900">{{ $allocation->state_name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-sm text-gray-600 font-medium">{{ number_format($allocation->state_quota) }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-sm font-black text-ferti-green">{{ number_format($allocation->remaining_quota) }}</span>
                        </td>
                        <td class="px-8 py-5 ">
                            {{ $allocation->status }}
                        </td>
                        <td class="px-8 py-5 min-w-[200px]">
                            <div class="flex items-center gap-4">
                                <div class="flex-1 bg-gray-100 h-2 rounded-full overflow-hidden">
                                    @php
                                        $percent = $allocation->percent_remaining;
                                        $colorClass = $percent > 50 ? 'bg-ferti-green' : ($percent > 20 ? 'bg-amber-500' : 'bg-red-500');
                                    @endphp
                                    <div class="{{ $colorClass }} h-full transition-all duration-1000" style="width: {{ $percent }}%"></div>
                                </div>
                                <span class="text-[11px] font-black {{ str_replace('bg-', 'text-', $colorClass) }} w-10">
                                    {{ $percent }}%
                                </span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-admin.layout>