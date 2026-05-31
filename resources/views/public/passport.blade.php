@extends('layouts.public')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Main Passport Card -->
        <div class="bg-white rounded-[3rem] shadow-2xl shadow-blue-900/10 border border-blue-100 overflow-hidden relative mb-12">
            <!-- Decorative Background Pattern -->
            <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%231e40af\" fill-opacity=\"1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4v-4H4v4H0v2h4v4h2v-4h4v-2H6zM36 4v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

            <!-- Top Header Section -->
            <div class="bg-[#1E40AF] p-10 lg:p-12 text-center text-white relative overflow-hidden">
                <!-- Blur Accents -->
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-blue-400/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-12 -left-12 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>

                <div class="relative z-10">
                    <div class="w-20 h-20 bg-white/10 backdrop-blur-md rounded-[2rem] flex items-center justify-center mx-auto mb-6 border border-white/20 shadow-xl">
                        <i class="fa-solid fa-circle-check text-3xl text-blue-300"></i>
                    </div>
                    <h1 class="text-4xl font-black uppercase tracking-tight mb-2">Authentic Product</h1>
                    <p class="text-blue-300 text-[10px] font-black uppercase tracking-[0.3em]">Official Digital Passport</p>
                    
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
                            <i class="fa-solid fa-industry text-blue-500"></i>
                            Production Detail
                        </h2>
                        <div class="bg-gray-50/50 p-6 rounded-3xl border border-gray-100 shadow-inner">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-[9px] text-gray-400 uppercase font-bold tracking-wider mb-1">Batch Reference</p>
                                    <p class="text-lg font-black text-[#1E40AF]">{{ $item->batch->batch_number }}</p>
                                </div>
                                <div>
                                    <p class="text-[9px] text-gray-400 uppercase font-bold tracking-wider mb-1">Minted By (Official)</p>
                                    <p class="text-lg font-black text-[#1E40AF]">{{ $item->batch->creator->name ?? 'System Registry' }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">Origin: {{ $item->batch->creator->state ?? 'National Headquarters' }}</p>
                                </div>
                                <div>
                                    <p class="text-[9px] text-gray-400 uppercase font-bold tracking-wider mb-1">Production Date</p>
                                    <p class="text-lg font-black text-[#1E40AF]">{{ $item->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Info -->
                    <div class="space-y-4">
                        <h2 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                            <i class="fa-solid fa-tags text-blue-500"></i>
                            Market Economics
                        </h2>
                        <div class="bg-blue-50 p-6 rounded-3xl border border-blue-100 shadow-inner flex flex-col justify-center h-full">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <p class="text-[9px] text-gray-400 uppercase font-bold">Standard Market Value</p>
                                    <p class="text-sm font-black text-gray-400 line-through">₦{{ number_format($item->batch->market_price) }}</p>
                                </div>
                                <div class="flex justify-between items-end">
                                    <div>
                                        <p class="text-[10px] text-blue-600 uppercase font-black tracking-widest mb-1">Official Subsidized Price</p>
                                        <p class="text-3xl font-black text-[#1E40AF]">₦{{ number_format($item->batch->subsidized_price) }}</p>
                                    </div>
                                    <div class="w-10 h-10 bg-[#3B82F6] rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
                                        <i class="fa-solid fa-certificate"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Journey Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <h2 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                            <i class="fa-solid fa-route text-blue-500"></i>
                            Logistics Path
                        </h2>
                        <div class="bg-gray-50/50 p-6 rounded-3xl border border-gray-100 shadow-inner">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-[9px] text-gray-400 uppercase font-bold tracking-wider mb-1">Target Destination</p>
                                    <p class="text-lg font-black text-[#1E40AF]">{{ $item->batch->target_state }} State</p>
                                </div>
                                <div>
                                    <p class="text-[9px] text-gray-400 uppercase font-bold tracking-wider mb-1">Verified Receipt By</p>
                                    <p class="text-lg font-black text-[#1E40AF]">{{ $item->batch->acceptor->name ?? 'Awaiting Arrival' }}</p>
                                    @if($item->batch->acceptor)
                                        <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">Designated Depot: {{ $item->batch->target_state }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                            <i class="fa-solid fa-shield-check text-blue-500"></i>
                            Integrity Status
                        </h2>
                        <div class="bg-blue-900 text-white p-6 rounded-3xl shadow-xl flex flex-col justify-center h-full relative overflow-hidden group">
                            <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:opacity-20 transition-opacity">
                                <i class="fa-solid fa-fingerprint text-7xl"></i>
                            </div>
                            <p class="text-[10px] text-blue-300 uppercase font-black tracking-widest mb-1">Current Validation</p>
                            <p class="text-2xl font-black">{{ strtoupper($item->status) }}</p>
                            <p class="text-[9px] text-blue-200/60 font-medium mt-2 uppercase">Secured by ProductGuard Ledger</p>
                        </div>
                    </div>
                </div>

                <!-- QR Verification Section -->
                <div class="bg-gray-50/80 backdrop-blur-sm p-8 rounded-[2.5rem] border border-gray-100 text-center relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity">
                        <i class="fa-solid fa-fingerprint text-8xl text-[#1E40AF]"></i>
                    </div>

                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-6">Scan to re-verify product passport</p>
                    <div class="flex justify-center relative z-10">
                        <div class="bg-white p-4 rounded-3xl shadow-xl border border-gray-50 group-hover:scale-105 transition-transform duration-500">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('public.item.passport', ['tag_number' => $item->tag_number])) }}" 
                                 alt="QR Code" class="w-32 h-32 grayscale group-hover:grayscale-0 transition-all duration-700">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Brand Bar -->
            <div class="bg-[#1E40AF] py-6 px-10 text-center relative">
                <div class="flex items-center justify-center gap-4 opacity-50">
                    <x-application-logo class="w-4 h-4 fill-current text-white" />
                    <p class="text-[10px] font-black text-white uppercase tracking-[0.4em]">ProductGuard Secure Network</p>
                </div>
            </div>
        </div>

        <!-- Feedback & Report Section -->
        <div class="bg-white rounded-[3rem] p-10 border border-blue-100 shadow-xl shadow-blue-500/5 relative overflow-hidden">
            <div class="absolute -top-12 -left-12 w-32 h-32 bg-blue-500/5 rounded-full blur-2xl"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-[#1E40AF]">
                        <i class="fa-solid fa-comment-dots text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-gray-800">Public Feedback</h3>
                        <p class="text-xs text-gray-500 font-medium">Help us maintain integrity. Share your experience.</p>
                    </div>
                </div>
                
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-100 flex items-center gap-3 text-green-600">
                        <i class="fa-solid fa-circle-check"></i>
                        <p class="font-bold text-xs uppercase tracking-widest">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-100 flex items-center gap-3 text-amber-600">
                        <i class="fa-solid fa-circle-info"></i>
                        <p class="font-bold text-xs uppercase tracking-widest">{{ session('error') }}</p>
                    </div>
                @endif
                
                <form action="{{ route('public.report.submit', $item->id) }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="is_positive" value="1" class="peer hidden" checked>
                            <div class="p-4 rounded-2xl border-2 border-gray-50 bg-gray-50/50 text-center transition-all peer-checked:border-green-500 peer-checked:bg-green-50 group-hover:bg-gray-100">
                                <i class="fa-solid fa-face-smile text-2xl text-gray-300 peer-checked:text-green-500 mb-1 block"></i>
                                <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 peer-checked:text-green-600">All Good</span>
                            </div>
                        </label>
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="is_positive" value="0" class="peer hidden">
                            <div class="p-4 rounded-2xl border-2 border-gray-50 bg-gray-50/50 text-center transition-all peer-checked:border-red-500 peer-checked:bg-red-50 group-hover:bg-gray-100">
                                <i class="fa-solid fa-face-frown text-2xl text-gray-300 peer-checked:text-red-500 mb-1 block"></i>
                                <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 peer-checked:text-red-600">Report Issue</span>
                            </div>
                        </label>
                    </div>
                    
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Comments (Optional)</label>
                        <textarea name="comment" rows="3" placeholder="Tell us more about the product condition..." 
                            class="w-full bg-gray-50/50 border-gray-100 rounded-2xl p-4 text-sm text-gray-700 placeholder:text-gray-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-[#1E40AF] text-white py-5 rounded-2xl font-black uppercase tracking-widest text-sm shadow-xl shadow-blue-900/20 hover:bg-blue-800 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                        Submit Feedback
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection