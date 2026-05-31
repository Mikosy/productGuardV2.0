@extends('layouts.public')

@extends('layouts.public')

@section('content')
<script src="https://unpkg.com/html5-qrcode"></script>

<div class="max-w-xl mx-auto">
    <div class="bg-white p-10 rounded-[3rem] shadow-2xl shadow-blue-900/5 border border-blue-100 relative overflow-hidden text-center">
        <!-- Top Accent Bar -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-transparent via-[#3B82F6] to-transparent"></div>

        <div class="mb-10">
            <div class="w-20 h-20 bg-blue-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6 text-[#1E40AF] border border-blue-100">
                <i class="fa-solid fa-qrcode text-3xl"></i>
            </div>
            <h1 class="text-3xl font-black text-[#1E40AF] mb-2 uppercase tracking-tight">Trust Verification Portal</h1>
            <p class="text-gray-400 text-sm font-medium">Verify any ProductGuard integrity-secured item instantly.</p>
        </div>

        <!-- Scanner UI Container -->
        <div id="qr-reader-container" class="mb-10 hidden">
            <div id="qr-reader" class="overflow-hidden rounded-3xl border-4 border-blue-50 shadow-inner bg-gray-50"></div>
            
            <div class="mt-4 flex flex-col items-center gap-4">
                <label class="cursor-pointer text-xs font-bold text-[#1E40AF] hover:text-[#3B82F6] transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-file-image"></i>
                    <span>Upload QR Image</span>
                    <input type="file" id="qr-input-file" accept="image/*" class="hidden">
                </label>

                <button type="button" id="stop-scan" class="text-xs font-black text-red-500 uppercase tracking-widest hover:text-red-700 transition-colors">
                    Stop Camera
                </button>
            </div>
        </div>

        <form id="verifyForm" action="{{ route('public.search') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="relative group">
                <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none text-gray-300 group-focus-within:text-[#3B82F6] transition-colors">
                    <i class="fa-solid fa-barcode text-xl"></i>
                </div>
                <input type="text" id="tag_input" name="tag_number" 
                       placeholder="ENTER TAG ID" 
                       class="w-full pl-14 pr-6 py-5 rounded-2xl bg-gray-50/50 border border-gray-100 text-center font-mono font-black text-xl uppercase tracking-[0.3em] text-[#1E40AF] placeholder:text-gray-200 focus:ring-4 focus:ring-blue-500/10 focus:border-[#3B82F6] focus:bg-white outline-none transition-all shadow-inner"
                       required>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <button type="button" id="start-scan" class="w-full bg-[#3B82F6] text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-sm shadow-xl shadow-blue-500/20 hover:bg-[#2563EB] transition-all flex items-center justify-center gap-3">
                    <i class="fa-solid fa-camera"></i>
                    Scan QR Code
                </button>
                
                <button type="submit" class="w-full bg-[#1E40AF] text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-sm shadow-xl shadow-blue-900/20 hover:bg-blue-800 transition-all flex items-center justify-center gap-3">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Track Item
                </button>
            </div>
        </form>

        @if(session('error'))
            <div class="mt-8 p-4 rounded-2xl bg-red-50 border border-red-100 flex items-center gap-3 text-red-600">
                <i class="fa-solid fa-circle-exclamation"></i>
                <p class="font-bold text-xs uppercase tracking-widest">{{ session('error') }}</p>
            </div>
        @endif

        <div class="mt-10 pt-8 border-t border-gray-50">
            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">
                Official Public Verification Portal
            </p>
        </div>
    </div>
</div>

<script>
    let html5QrCode;
    const startBtn = document.getElementById('start-scan');
    const stopBtn = document.getElementById('stop-scan');
    const fileInput = document.getElementById('qr-input-file');
    const readerContainer = document.getElementById('qr-reader-container');
    const tagInput = document.getElementById('tag_input');
    const verifyForm = document.getElementById('verifyForm');

    function onScanSuccess(decodedText) {
        let tag = decodedText;
        if (decodedText.includes('/passport/')) {
            tag = decodedText.split('/passport/').pop();
        }
        tagInput.value = tag;
        stopScanning().then(() => verifyForm.submit());
    }

    async function stopScanning() {
        if (html5QrCode && html5QrCode.isScanning) {
            await html5QrCode.stop();
        }
        readerContainer.classList.add('hidden');
        startBtn.classList.remove('hidden');
    }

    startBtn.addEventListener('click', () => {
        readerContainer.classList.remove('hidden');
        startBtn.classList.add('hidden');
        if (!html5QrCode) html5QrCode = new Html5Qrcode("qr-reader");
        
        html5QrCode.start({ facingMode: "environment" }, { fps: 15, qrbox: 250 }, onScanSuccess)
            .catch(err => {
                alert("Camera failed. Use the 'Upload QR Image' option.");
            });
    });

    fileInput.addEventListener('change', e => {
        if (e.target.files.length == 0) return;
        if (!html5QrCode) html5QrCode = new Html5Qrcode("qr-reader");
        html5QrCode.scanFile(e.target.files[0], true)
            .then(onScanSuccess)
            .catch(err => alert("Could not find a valid QR code."));
    });

    stopBtn.addEventListener('click', stopScanning);
</script>
@endsection