<x-admin.layout>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Incident Management Desk</h1>
            <p class="text-sm text-gray-500 mt-1">Review critical cargo damage files reported by regional depots and dispatch stock corrections.</p>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden">
            <table class="min-w-full divide-y divide-gray-100 text-left">
                <thead class="bg-gray-50/70 text-[10px] font-black uppercase text-gray-400 tracking-widest">
                    <tr>
                        <th class="px-6 py-4">Damaged Serial Token</th>
                        <th class="px-6 py-4">Order Reference</th>
                        <th class="px-6 py-4">Reporting Node</th>
                        <th class="px-6 py-4">Affected Citizen</th>
                        <th class="px-6 py-4 text-right">Administrative Resolution</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm font-medium text-gray-700">
                    @forelse($damagedItems as $item)
                        <tr class="hover:bg-red-50/30 transition-colors">
                            <!-- Damaged Serial Token -->
                            <td class="px-6 py-4 font-mono text-xs text-red-600 font-bold">
                                {{ $item->item_tracking_id }}
                            </td>

                            <!-- Damage Proof Image Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->damage_proof_image)
                                    <div class="relative group w-16 h-16 rounded-xl overflow-hidden border border-gray-200 bg-gray-50 shadow-sm">
                                        <img src="{{ asset('storage/' . $item->damage_proof_image) }}" 
                                            alt="Proof of damage" 
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-200">
                                        
                                        <!-- Lightbox/Full-screen Hover Link overlay -->
                                        <a href="{{ asset('storage/' . $item->damage_proof_image) }}" 
                                        target="_blank" 
                                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-[10px] font-black uppercase tracking-wider">
                                            View ↗
                                        </a>
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-gray-400 italic">
                                        <i class="fa-solid fa-circle-minus text-[10px]"></i> No Image Provided
                                    </span>
                                @endif
                            </td>

                            <!-- Reporting Node -->
                            <td class="px-6 py-4 uppercase text-gray-700 font-bold">
                                {{ $item->order->allocation->state_name ?? 'N/A' }} Depot
                            </td>

                            <!-- Affected Citizen -->
                            <td class="px-6 py-4">
                                <div class="text-gray-900 font-bold">{{ $item->order->user->name }}</div>
                                <div class="text-[10px] text-gray-400 font-mono">{{ $item->order->user->email }}</div>
                            </td>

                            <!-- Administrative Resolution -->
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.incidents.resolve', $item->id) }}" method="POST" class="inline-flex items-center gap-2">
                                    @csrf
                                    <select name="action" required class="text-xs font-bold bg-gray-50 border border-gray-200 rounded-xl p-2 focus:ring-2 focus:ring-[#1B4332] text-gray-600">
                                        <option value="replace_and_reissue">Reissue New Stock Unit</option>
                                        <option value="refund_quota">Void & Reclaim Quota</option>
                                    </select>
                                    <button type="submit" class="bg-[#1B4332] text-white text-[10px] font-black uppercase tracking-wider px-3 py-2 rounded-xl hover:bg-black transition-all">
                                        Execute
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-gray-400">
                                <p class="text-base font-bold">System clean: No unresolved cargo damage alerts reported.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($damagedItems->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $damagedItems->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin.layout>