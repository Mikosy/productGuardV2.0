<x-depot.layout>
    <x-slot:title>Inbound Cargo Intake</x-slot:title>
    
    <div class="max-w-6xl mx-auto px-6 py-12">
        <div class="mb-6">
            <a href="{{ route('depot.dashboard') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-black transition-colors">← Back to Command Center</a>
        </div>
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black tracking-tight text-[#1B4332]">Inbound Inspection Deck</h1>
                <p class="text-gray-500 text-sm mt-1">Verify batch integrity of stock allocated to your state and manage damage reports.</p>
            </div>

            <form action="{{ route('depot.intake.index') }}" method="GET" class="w-full md:w-80">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Item Tracking ID..." 
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
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Item Tracking ID</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Current Status</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Date Logged</th>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($items as $item)
                            <tr class="hover:bg-gray-50/80 transition-all">
                                <td class="px-8 py-6 font-mono text-xs font-bold text-gray-900">{{ $item->item_tracking_id }}</td>
                                <td class="px-8 py-6">
                                    <span class="inline-block px-2.5 py-1 text-[9px] font-black uppercase tracking-widest rounded border 
                                        {{ $item->status === 'collected' ? 'bg-blue-50 text-blue-700 border-blue-100' : '' }}
                                        {{ $item->status === 'paid' ? 'bg-green-50 text-green-700 border-green-100' : '' }}
                                        {{ $item->status === 'received' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : '' }}
                                        {{ $item->status === 'damaged' ? 'bg-red-50 text-red-700 border-red-100' : '' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-xs text-gray-500 font-medium">{{ $item->created_at->format('M d, Y H:i A') }}</td>
                                <td class="px-8 py-6 text-right flex items-center justify-end gap-2">
                                    @if($item->status === 'paid')
                                        <form action="{{ route('depot.verify.collect') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                                            <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-[#1B4332] hover:text-white text-[10px] font-black uppercase tracking-widest transition-all shadow-sm">
                                                Acknowledge Receipt
                                            </button>
                                        </form>

                                        <button onclick="toggleDamageModal('{{ $item->id }}', '{{ $item->item_tracking_id }}')" class="px-3 py-1.5 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white text-[10px] font-black uppercase tracking-widest transition-all shadow-sm">
                                            Flag Damage
                                        </button>
                                    @else
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mr-2">Processed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-16 text-gray-400 text-xs font-medium">
                                    No localized item units identified in the matching tracking registry.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6">
            {{ $items->links() }}
        </div>
    </div>

    <div id="damageModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-[2rem] max-w-md w-full p-8 shadow-2xl border border-gray-100">
            <h3 class="text-xl font-black text-[#1B4332] mb-1">Report Cargo Damage</h3>
            <p class="text-gray-400 text-xs font-medium mb-6">Item: <span id="modalItemIdDisplay" class="font-mono font-bold text-gray-700"></span></p>
            
            <form id="damageForm" method="POST" action="" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-5">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Live Proof Attachment (Tag Visible)</label>
                    <div class="relative flex items-center justify-center w-full grid">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-200 rounded-2xl cursor-pointer bg-gray-50/50 hover:bg-gray-50 transition-colors p-4">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center">
                                <i class="fa-solid fa-camera text-gray-400 text-xl mb-2"></i>
                                <p class="text-[11px] font-bold text-gray-500">Upload Live Inspection Photo</p>
                                <p class="text-[9px] text-gray-400 mt-0.5">JPEG, PNG, or WEBP (Max 5MB)</p>
                            </div>
                            <input type="file" name="proof_image" required accept="image/*" class="hidden" onchange="updateFileLabel(this)">
                        </label>
                    </div>
                    <p id="file-chosen-text" class="text-[10px] font-mono text-emerald-600 font-bold mt-2 text-center hidden"></p>
                </div>

                <div class="mb-6">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Inspection Notes / Damage Reason</label>
                    <textarea name="notes" required rows="3" placeholder="Describe the condition of the goods (e.g., torn packaging, water exposure)..." 
                        class="w-full p-4 text-xs border border-gray-200 rounded-2xl focus:outline-none focus:border-red-500 bg-gray-50/50 resize-none"></textarea>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" onclick="toggleDamageModal()" class="w-1/2 py-3 bg-gray-100 text-gray-500 font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-gray-200 transition-all">
                        Cancel
                    </button>
                    <button type="submit" class="w-1/2 py-3 bg-red-600 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-black transition-all shadow-lg shadow-red-600/10">
                        Submit Log
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateFileLabel(input) {
            const textDisplay = document.getElementById('file-chosen-text');
            if (input.files && input.files.length > 0) {
                textDisplay.innerText = "✓ Photo selected: " + input.files[0].name;
                textDisplay.classList.remove('hidden');
            } else {
                textDisplay.classList.add('hidden');
            }
        }
    </script>

    <script>
        function toggleDamageModal(itemId = '', trackingId = '') {
            const modal = document.getElementById('damageModal');
            const display = document.getElementById('modalItemIdDisplay');
            const form = document.getElementById('damageForm');
            
            if(modal.classList.contains('hidden')) {
                display.innerText = trackingId;
                // Dynamically sets action to point to your controller's damage handler endpoint
                form.action = `/depot/intake/${itemId}/damage`;
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }
    </script>
</x-depot.layout>