<x-admin.layout>
    <div class="max-w-5xl mx-auto py-12 px-6">
        <div class="mb-8">
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Print Bag Tags & Dispatch</h1>
            <p class="text-sm text-gray-500 mt-1">Select a state region to access secure QR verification stickers for paid cargo items.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($stateGroups as $stateName => $items)
                <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <span class="px-2.5 py-1 bg-emerald-50 text-[#064E3B] text-[10px] font-black uppercase rounded-md tracking-wider">
                            Active Region
                        </span>
                        <h3 class="text-xl font-black text-gray-800 mt-3">{{ $stateName }}</h3>
                        <p class="text-sm font-bold text-gray-400 mt-1">{{ $items->count() }} bags waiting for print</p>
                    </div>

                    <div class="mt-8">
                        <a href="{{ route('admin.dispatch.state.orders', $stateName) }}" 
                           class="inline-flex w-full items-center justify-center px-4 py-3 text-xs font-black uppercase tracking-widest text-white bg-[#064E3B] hover:bg-black rounded-xl transition-all text-center">
                            Open Print Console →
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white border border-dashed rounded-3xl p-12 text-center text-gray-400">
                    <i class="fa-solid fa-box-open text-3xl mb-3"></i>
                    <p class="text-sm font-bold">No items waiting for tag printing today.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-admin.layout>