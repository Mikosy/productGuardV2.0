<x-depot.layout>
    <x-slot:title>Token Authentication Terminal</x-slot:title>

    <div class="max-w-4xl mx-auto py-12 px-4">
        
        <div class="mb-8">
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Security Gate</p>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight mt-1">Token Authentication Terminal</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
            
            <div class="md:col-span-1 space-y-6">
                <div class="bg-white border border-gray-100 rounded-[2rem] p-6 shadow-xl shadow-gray-100/40">
                    <h2 class="text-xs font-black uppercase tracking-widest text-gray-900 mb-4">Scanner Entry</h2>
                    
                    <div class="relative aspect-square w-full bg-black rounded-xl overflow-hidden mb-4 border border-gray-100">
                        <video id="scannerStream" class="w-full h-full object-cover"></video>
                        <div class="absolute inset-0 border-2 border-dashed border-[#064E3B]/40 pointer-events-none m-8 rounded-lg animate-pulse"></div>
                    </div>

                    <form action="{{ route('depot.verify.lookup') }}" method="GET" class="space-y-3">
                        <input type="text" name="target_id" value="{{ $target }}" placeholder="Enter Tracking Token ID manually..." 
                            class="w-full px-4 py-3 text-xs border border-gray-200 rounded-xl focus:outline-none focus:border-black font-mono uppercase">
                        <button type="submit" class="w-full py-3 bg-[#064E3B] text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-black transition-colors shadow-sm">
                            Execute Search
                        </button>
                    </form>
                </div>
            </div>

            <div class="md:col-span-2">
                @if($error)
                    <div class="bg-red-50 border border-red-100 rounded-[2rem] p-8 text-center text-red-700">
                        <i class="fa-solid fa-triangle-exclamation text-2xl mb-2"></i>
                        <h3 class="font-bold text-sm">Authentication Failure</h3>
                        <p class="text-xs mt-1 text-red-600/90 font-medium">{{ $error }}</p>
                    </div>
                @elseif($item)
                    <div class="bg-white border border-gray-100 rounded-[2rem] p-8 shadow-xl shadow-gray-100/40">
                        <p class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-1">Authenticated Token Verified</p>
                        <h2 class="text-2xl font-black font-mono text-gray-900 tracking-tight mb-6">{{ $item->item_tracking_id }}</h2>
                        
                        <div class="grid grid-cols-2 gap-6 pt-4 border-t border-gray-50 mb-6">
                            <div>
                                <p class="text-[9px] font-black uppercase tracking-widest text-gray-400">Authorized Holder</p>
                                <p class="text-base font-bold text-gray-900 mt-0.5">{{ $item->order->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black uppercase tracking-widest text-gray-400">Current Status</p>
                                <span class="inline-block mt-1 px-2.5 py-0.5 text-[9px] font-black uppercase tracking-widest rounded border
                                    {{ $item->status === 'collected' ? 'bg-blue-50 text-blue-700 border-blue-100' : '' }}
                                    {{ $item->status === 'paid' ? 'bg-green-50 text-green-700 border-green-100' : '' }}
                                    {{ $item->status === 'damaged' ? 'bg-red-50 text-red-700 border-red-100' : '' }}">
                                    {{ $item->status }}
                                </span>
                            </div>
                        </div>

                        @if($item->status === 'paid')
                            <form action="{{ route('depot.verify.collect') }}" method="POST" class="pt-4 border-t border-gray-50">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <button type="submit" class="w-full py-4 bg-[#064E3B] text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-black transition-all shadow-lg shadow-green-900/10">
                                    Confirm Physical Handover
                                </button>
                            </form>
                        @elseif($item->status === 'collected')
                            <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-4 text-center text-blue-700 text-xs font-bold">
                                ✓ This secure item token was already logged out of active depot pools.
                            </div>
                        @else
                            <div class="bg-red-50 border border-red-100 rounded-xl p-4 text-center text-red-700 text-xs font-bold">
                                ✕ Handover blocked: This unit is flagged as damaged stock.
                            </div>
                        @endif
                    </div>
                @else
                    <div class="bg-gray-50 border border-dashed border-gray-200 rounded-[2rem] p-16 text-center text-gray-400">
                        <i class="fa-solid fa-expand text-3xl mb-3"></i>
                        <h3 class="text-sm font-bold text-gray-900">Awaiting Authentication Input</h3>
                        <p class="text-xs max-w-xs mx-auto mt-1 font-medium">Position a secure QR code in front of the terminal camera framework or query the item token serial id string manually.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Redirect the Officer to the parsed link immediately when captured
            window.location.href = `{{ route('depot.verify.lookup') }}?target_id=${encodeURIComponent(decodedText)}`;
        }

        let html5QrcodeScanner = new Html5Qrcode("scannerStream");
        html5QrcodeScanner.start(
            { facingMode: "environment" }, 
            { fps: 10, qrbox: { width: 250, height: 250 } },
            onScanSuccess
        ).catch(err => console.warn("Camera stream could not initialize:", err));
    </script>
</x-depot.layout>