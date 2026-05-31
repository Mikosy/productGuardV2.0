<x-consumer.layout>
    <script src="https://unpkg.com/html5-qrcode"></script>

    
    <div class="max-w-2xl mx-auto px-6 py-12">
        <!-- Back Button -->
        <a href="{{ route('consumer.verify') }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-[#064E3B] transition-colors mb-8 group">
            <span class="group-hover:-translate-x-1 transition-transform">←</span> Back to Search
        </a>

        <!-- Main Passport Card -->
        <div class="bg-white rounded-[3rem] shadow-2xl shadow-[#064E3B]/10 border border-emerald-100/50 overflow-hidden relative">
            <!-- Decorative Background Pattern -->
            <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23064e3b\" fill-opacity=\"1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4v-4H4v4H0v2h4v4h2v-4h4v-2H6zM36 4v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

            <!-- Top Header Section -->
            <div class="bg-[#064E3B] p-10 lg:p-12 text-center text-white relative overflow-hidden">
                <!-- Blur Accents -->
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-[#10B981]/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-12 -left-12 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>

                <div class="relative z-10">
                    <div class="w-20 h-20 bg-white/10 backdrop-blur-md rounded-[2rem] flex items-center justify-center mx-auto mb-6 border border-white/20 shadow-xl">
                        <x-application-logo class="w-12 h-12 fill-current text-white drop-shadow-md" />
                    </div>
                    <h1 class="text-4xl font-black uppercase tracking-tight mb-2">Verified Authenticity</h1>
                    <p class="text-[#10B981] text-[10px] font-black uppercase tracking-[0.3em]">Digital Product Passport</p>
                    
                    <div class="mt-8 inline-flex items-center gap-3 bg-white/10 backdrop-blur-md px-6 py-2 rounded-2xl border border-white/10 text-sm font-mono font-black tracking-widest">
                        <span class="opacity-50 text-[10px] font-sans uppercase">ID:</span>
                        {{ $item->tag_number }}
                    </div>
                </div>
            </div>

            <!-- Content Body -->
            <div class="p-10 lg:p-12 space-y-10 relative z-10">
                <!-- Batch Origin Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <h2 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                            <i class="fa-solid fa-industry text-[#10B981]"></i>
                            Batch Origin
                        </h2>
                        <div class="bg-gray-50/50 p-6 rounded-3xl border border-gray-100 shadow-inner">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-[9px] text-gray-400 uppercase font-bold tracking-wider mb-1">Batch Reference</p>
                                    <p class="text-lg font-black text-[#064E3B]">{{ $item->batch->batch_number }}</p>
                                </div>
                                <div>
                                    <p class="text-[9px] text-gray-400 uppercase font-bold tracking-wider mb-1">Minted By</p>
                                    <p class="text-lg font-black text-[#064E3B]">
                                        {{ $item->batch->creator->name ?? 'Unknown' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-[9px] text-gray-400 uppercase font-bold tracking-wider mb-1">Minting Timestamp</p>
                                    <p class="text-lg font-black text-[#064E3B]">{{ $item->batch->created_at->format('d M, Y — H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Info -->
                    <div class="space-y-4">
                        <h2 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                            <i class="fa-solid fa-tags text-[#10B981]"></i>
                            Market Economics
                        </h2>
                        <div class="bg-[#064E3B]/5 p-6 rounded-3xl border border-[#064E3B]/10 shadow-inner flex flex-col justify-center h-full">
                            <div class="flex justify-between items-center mb-4">
                                <p class="text-[9px] text-gray-400 uppercase font-bold">Standard Market Value</p>
                                <p class="text-xs font-black text-gray-400 line-through">₦{{ number_format($item->batch->market_price) }}</p>
                            </div>
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-[10px] text-[#10B981] uppercase font-black tracking-widest mb-1">Subsidized Price</p>
                                    <p class="text-3xl font-black text-[#064E3B]">₦{{ number_format($item->batch->subsidized_price) }}</p>
                                </div>
                                <div class="w-10 h-10 bg-[#10B981] rounded-xl flex items-center justify-center text-white shadow-lg shadow-[#10B981]/20">
                                    <i class="fa-solid fa-certificate"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logistics Timeline -->
                <div class="space-y-6">
                    <h2 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                        <i class="fa-solid fa-truck-fast text-[#10B981]"></i>
                        Chain of Custody
                    </h2>
                    <div class="relative pl-8 border-l-2 border-dashed border-emerald-100 space-y-8 ml-2">
                        <!-- Arrival Step -->
                        <div class="relative">
                            <div class="absolute -left-[41px] top-0 w-5 h-5 bg-[#10B981] rounded-full border-4 border-white shadow-sm shadow-[#10B981]/50"></div>
                            <div>
                                <p class="text-[10px] font-black text-[#10B981] uppercase tracking-widest mb-1">State Arrival</p>
                                <h4 class="text-sm font-black text-[#064E3B]">{{ $item->batch->target_state }} Confirmation</h4>
                                <p class="text-xs text-gray-500 mt-1">Shipment verified and received at state depot center.</p>
                            </div>
                        </div>
                        <!-- Confirmed Step -->
                        <div class="relative">
                            <div class="absolute -left-[41px] top-0 w-5 h-5 bg-[#064E3B] rounded-full border-4 border-white"></div>
                            <div class="flex justify-between items-start gap-4">
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Custodian Signature</p>
                                    <h4 class="text-sm font-black text-[#064E3B]">{{ $item->batch->acceptor->name ?? 'Awaiting Sign-off' }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">Authorized Depot Officer verification status.</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Timestamp</p>
                                    <p class="text-xs font-black text-[#064E3B]">{{ $item->batch->received_at ? \Carbon\Carbon::parse($item->batch->received_at)->format('M d, Y') : 'Processing' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- QR Verification Footer -->
                <div class="bg-gray-50/80 backdrop-blur-sm p-8 rounded-[2.5rem] border border-gray-100 text-center relative overflow-hidden group">
                    <!-- Subtle fingerprint icon -->
                    <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity">
                        <i class="fa-solid fa-fingerprint text-8xl text-[#064E3B]"></i>
                    </div>

                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-6">Scan to re-verify item passport</p>
                    <div class="flex justify-center relative z-10">
                        <div class="bg-white p-4 rounded-3xl shadow-xl border border-gray-50 group-hover:scale-105 transition-transform duration-500">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('public.item.passport', ['tag_number' => $item->tag_number])) }}" 
                            alt="QR Code">
                        </div>
                    </div>
                    <div class="mt-8">
                        <p class="text-xs font-black text-[#064E3B] uppercase tracking-widest flex items-center justify-center gap-2">
                            <i class="fa-solid fa-lock text-[#10B981]"></i>
                            Secured by ProductGuard™
                        </p>
                    </div>
                </div>

                <!-- Report Form -->

                <div class="mt-10 border-t border-gray-100 pt-10">
                    <h2 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-comment-dots text-[#10B981]"></i>
                        Submit Product Report
                    </h2>

                    @if(session('success'))
                        <div class="bg-green-50 text-green-700 p-4 rounded-2xl text-xs font-bold mb-4">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="bg-red-50 text-red-700 p-4 rounded-2xl text-xs font-bold mb-4">
                            {{ session('error') }}
                        </div>
                    @else
                        <form action="{{ route('consumer.report.store', $item->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="flex gap-4">
                                <label class="flex-1 cursor-pointer group">
                                    <input type="radio" name="is_positive" value="1" class="hidden peer" required>
                                    <div class="p-4 rounded-2xl border-2 border-gray-100 text-center peer-checked:border-[#10B981] peer-checked:bg-[#10B981]/5 transition-all">
                                        <i class="fa-solid fa-thumbs-up text-2xl text-gray-300 group-hover:text-green-500 peer-checked:text-[#10B981]"></i>
                                        <p class="text-[9px] font-black uppercase mt-2 text-gray-400 peer-checked:text-[#10B981]">Item is Good and Not Overpriced</p>
                                    </div>
                                </label>

                                <label class="flex-1 cursor-pointer group">
                                    <input type="radio" name="is_positive" value="0" class="hidden peer">
                                    <div class="p-4 rounded-2xl border-2 border-gray-100 text-center peer-checked:border-red-500 peer-checked:bg-red-50 transition-all">
                                        <i class="fa-solid fa-thumbs-down text-2xl text-gray-300 group-hover:text-red-500 peer-checked:text-red-500"></i>
                                        <p class="text-[9px] font-black uppercase mt-2 text-gray-400 peer-checked:text-red-500">Item is Damaged or Overpriced</p>
                                    </div>
                                </label>
                            </div>

                            <textarea name="comment" rows="2" 
                                class="w-full rounded-2xl border-gray-100 bg-gray-50/50 p-4 text-sm focus:ring-[#10B981] focus:border-[#10B981]" 
                                placeholder="Optional: Tell us more about what you observed..."></textarea>

                            <button type="submit" class="w-full bg-[#064E3B] text-white py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-[#085F48] transition-all">
                                Submit Report
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Bottom Brand Bar -->
            <div class="bg-[#064E3B] py-6 px-10 text-center relative">
                <div class="flex items-center justify-center gap-4 opacity-50">
                    <x-application-logo class="w-4 h-4 fill-current text-white" />
                    <p class="text-[10px] font-black text-white uppercase tracking-[0.4em]">Integrity Systems Nigeria</p>
                </div>
            </div>
        </div>
    </div>
</x-consumer.layout>