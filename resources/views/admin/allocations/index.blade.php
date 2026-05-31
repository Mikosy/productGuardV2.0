<x-admin.layout>
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">National Allocations</h1>
            <p class="text-gray-500 mt-1">Manage and monitor federal resource distribution across states.</p>
        </div>
        <a href="{{ route('admin.allocations.create') }}" class="inline-flex items-center justify-center px-6 py-3.5 bg-ferti-green text-white text-sm font-bold rounded-2xl hover:bg-black transition-all shadow-sm hover:shadow-md group">
            <i class="fa-solid fa-plus mr-2 text-xs group-hover:rotate-90 transition-transform"></i>
            New Allocation
        </a>
    </div>

    @if($batches->isEmpty())
    <div class="bg-white rounded-[2rem] p-16 text-center border border-dashed border-gray-200 shadow-sm">
        <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mx-auto mb-6">
            <i class="fa-solid fa-boxes-stacked text-3xl text-gray-300"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">No allocations found</h3>
        <p class="text-gray-500 max-w-sm mx-auto mb-8">You haven't created any national allocations yet. Start by distributing resources to states.</p>
        <a href="{{ route('admin.allocations.create') }}" class="inline-flex items-center text-ferti-green font-bold hover:underline">
            Create your first allocation <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($batches as $batch)
        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col group">
            <div class="p-8 flex-1">
                <div class="flex items-start justify-between mb-6">
                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-ferti-green group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-box-open text-2xl"></i>
                    </div>
                    <div class="flex gap-2">
                        <form action="{{ route('admin.allocations.destroy', $batch->id) }}" method="POST" onsubmit="return confirm('Delete this entire national allocation? This action cannot be undone.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <h3 class="text-xl font-black text-gray-900 mb-2 group-hover:text-ferti-green transition-colors">{{ $batch->product_name }}</h3>
                
                <div class="space-y-3 mb-8">
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fa-solid fa-layer-group w-6 text-gray-400"></i>
                        <span>Total: <span class="font-bold text-gray-900">{{ number_format($batch->total_quantity) }}</span> units</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fa-solid fa-calendar-day w-6 text-gray-400"></i>
                        <span>Created: <span class="font-medium text-gray-700">{{ $batch->created_at->format('M d, Y') }}</span></span>
                    </div>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fa-solid fa-user w-6 text-gray-400"></i>
                        <span>Created by: <span class="font-medium text-gray-700">{{ auth()->user()->name ?? 'Guest' }}</span></span>
                    </div>
                </div>
            </div>

            <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-50 mt-auto">
                <a href="{{ route('admin.allocations.show', $batch->id) }}" class="flex items-center justify-center w-full py-3 bg-white border border-gray-200 text-gray-900 text-sm font-bold rounded-xl hover:bg-ferti-green hover:text-white hover:border-ferti-green transition-all shadow-sm">
                    View Distribution Details
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-12">
        {{ $batches->links() }}
    </div>
    @endif
</div>
</x-admin.layout>