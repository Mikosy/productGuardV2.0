<x-consumer.layout>
    <div class="max-w-3xl mx-auto py-12 px-4">
        
        <div class="flex justify-between items-center mb-10">
            <a href="{{ route('consumer.orders.index') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-black transition-colors">
                ← Back to Claims
            </a>
            <div class="flex gap-2">
                <button onclick="window.print()" class="p-2 text-gray-400 hover:text-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                </button>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-2xl shadow-gray-200/50 overflow-hidden">
            <div class="px-10 pt-10 pb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight">Claim Receipt</h1>
                    <p class="text-sm text-gray-400 font-medium">Ref: <span class="text-[#064E3B] font-mono uppercase">{{ $order->payment_reference }}</span></p>
                </div>
                
                @php
                    $statusStyles = [
                        'paid' => 'bg-green-50 text-green-700 border-green-100',
                        'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
                        'failed' => 'bg-red-50 text-red-700 border-red-100',
                        'collected' => 'bg-blue-50 text-blue-700 border-blue-100',
                    ];
                @endphp
                <span class="px-6 py-2 rounded-full border {{ $statusStyles[$order->status] ?? 'bg-gray-50' }} text-xs font-black uppercase tracking-widest">
                    {{ $order->status }}
                </span>
            </div>

            <div class="px-10 flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-gray-200"></div>
                <div class="flex-1 h-[1px] bg-gray-100"></div>
                <div class="w-2 h-2 rounded-full bg-gray-200"></div>
            </div>

            <div class="p-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-12">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Product Detail</p>
                        <h2 class="text-xl font-bold text-gray-900">{{ $order->allocation->batch->product_name }}</h2>
                        <p class="text-sm text-gray-500 mt-1">Allocation State: {{ $order->allocation->state_name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Claimant Info</p>
                        <h2 class="text-xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-3xl p-8 mb-10">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 font-medium">Quantity Purchased</span>
                            <span class="text-gray-900 font-bold">{{ $order->quantity }} Units</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 font-medium">Unit Price (Subsidized)</span>
                            <span class="text-gray-900 font-bold">₦{{ number_format($order->allocation->batch->subsidized_price) }}</span>
                        </div>
                        <div class="h-[1px] bg-gray-200 my-4"></div>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-black text-gray-900 tracking-tight">Total Amount Paid</span>
                            <span class="text-2xl font-black text-[#064E3B]">₦{{ number_format($order->amount_paid) }}</span>
                        </div>
                    </div>
                </div>

                @if($order->status === 'paid')
                    <div class="mt-6 inline-block p-4 bg-white border border-gray-100 rounded-2xl shadow-sm">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $order->payment_reference }}&color=064E3B" 
                            alt="Order QR Code" 
                            class="w-[120px] h-[120px] mx-auto"
                            loading="lazy">
                            
                        <p class="text-[9px] uppercase font-black mt-3 text-gray-300 tracking-widest">
                            Scan to Verify
                        </p>
                    </div>
                @elseif($order->status === 'pending')
                    <a href="{{ route('consumer.orders.pay', $order->id) }}" class="block text-center py-5 bg-[#064E3B] text-white font-black rounded-2xl shadow-lg shadow-green-900/20 hover:bg-black transition-all">
                        COMPLETE PAYMENT
                    </a>
                @endif
            </div>
        </div>

        <!-- items ordered -->
        @if($order->items->isNotEmpty())
            <div class="mt-10 mb-10">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Item Verification Tokens</p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-[460px] overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($order->items as $item)
                        @php
                            // Build the comprehensive secure metadata payload for the QR Engine
                            $qrPayload = http_build_query([
                                'id' => $item->item_tracking_id,
                                'status' => $item->status,
                                'holder' => $order->user->name,
                                'mkt_price' => '₦' . number_format($order->allocation->batch->market_price),
                                'sub_price' => '₦' . number_format($order->allocation->batch->subsidized_price)
                            ]);
                        @endphp

                        <button type="button" 
                            onclick="openQrModal('{{ $item->item_tracking_id }}', '{{ rawurlencode($qrPayload) }}')"
                            class="group flex items-center justify-between p-3.5 bg-white border border-gray-100 rounded-xl shadow-sm hover:border-[#064E3B] hover:shadow-md transition-all text-left w-full">
                            
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 bg-gray-50 border border-gray-100 group-hover:bg-green-50 group-hover:border-green-200 rounded-lg flex items-center justify-center text-gray-400 group-hover:text-[#064E3B] transition-colors">
                                    <i class="fa-solid fa-qrcode text-[10px]"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-black font-mono text-gray-900 tracking-tight">{{ $item->item_tracking_id }}</p>
                                    <p class="text-[9px] font-medium text-gray-400 uppercase tracking-wider mt-0.5 group-hover:text-[#064E3B] transition-colors">Click to scan tag →</p>
                                </div>
                            </div>
                            
                            <span class="px-2 py-0.5 text-[8px] font-black uppercase tracking-widest rounded border transition-colors
                                {{ $item->status === 'collected' ? 'bg-blue-50 text-blue-700 border-blue-100' : '' }}
                                {{ $item->status === 'paid' ? 'bg-green-50 text-green-700 border-green-100' : '' }}
                                {{ $item->status === 'damaged' ? 'bg-red-50 text-red-700 border-red-100' : '' }}">
                                {{ $item->status }}
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        <div id="qrVerificationModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden opacity-0 transition-opacity duration-300 flex items-center justify-center p-4">
            <div class="bg-white rounded-[2rem] max-w-sm w-full border border-gray-100 p-8 shadow-2xl transform scale-95 transition-transform duration-300 relative text-center">
                
                <button onclick="closeQrModal()" class="absolute top-6 right-6 w-7 h-7 rounded-full bg-gray-50 hover:bg-gray-100 flex items-center justify-center text-gray-400 hover:text-black transition-colors text-xs font-bold">✕</button>
                
                <p class="text-[9px] font-black uppercase tracking-[0.2em] text-[#064E3B] mb-1">Security Authentication</p>
                <h3 id="modalTrackingId" class="text-lg font-black font-mono text-gray-900 tracking-tight mb-6">TOKEN-ID</h3>
                
                <div class="bg-gray-50 border border-gray-100 p-6 rounded-2xl inline-block mb-4 mx-auto group">
                    <img id="modalQrImage" src="" alt="Dynamic Secure Item QR Code" 
                        class="w-40 h-40 grayscale group-hover:grayscale-0 transition-all duration-700 mx-auto">
                </div>
                
                <p class="text-[10px] text-gray-400 font-medium max-w-[210px] mx-auto leading-relaxed">
                    Present this individual sticker payload token directly to the depot officer for deployment handling.
                </p>
            </div>
        </div>

        <script>
            function openQrModal(trackingId, urlPayload) {
                const modal = document.getElementById('qrVerificationModal');
                const modalTitle = document.getElementById('modalTrackingId');
                const modalImg = document.getElementById('modalQrImage');
                
                // Dynamically assign target values
                modalTitle.innerText = trackingId;
                modalImg.src = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&color=064E3B&data=${urlPayload}`;
                
                // Trigger presentation engine transitions
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    modal.querySelector('div').classList.remove('scale-95');
                }, 20);
            }

            function closeQrModal() {
                const modal = document.getElementById('qrVerificationModal');
                
                modal.classList.add('opacity-0');
                modal.querySelector('div').classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
            
            // Close modal safely on background shadow mask tap
            document.getElementById('qrVerificationModal').addEventListener('click', function(e) {
                if (e.target === this) closeQrModal();
            });
        </script>

        <style>
            .custom-scrollbar::-webkit-scrollbar { width: 4px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #064E3B; }
        </style>













        
    </div>
</x-consumer.layout>