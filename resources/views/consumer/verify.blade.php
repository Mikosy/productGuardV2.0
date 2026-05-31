<x-consumer.layout>
    <script src="https://unpkg.com/html5-qrcode"></script>

    <div class="max-w-xl mx-auto py-20 px-6">
        <div class="bg-white p-10 rounded-[3rem] shadow-2xl shadow-[#064E3B]/5 border border-emerald-100/50 relative overflow-hidden text-center">
            <!-- Top Accent Bar -->
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-transparent via-[#10B981] to-transparent"></div>

            <div class="mb-10">
                <div class="w-20 h-20 bg-[#064E3B]/5 rounded-[2rem] flex items-center justify-center mx-auto mb-6 text-[#064E3B] border border-[#064E3B]/10">
                    <i class="fa-solid fa-shield-halved text-3xl"></i>
                </div>
                <h1 class="text-3xl font-black text-[#064E3B] mb-2 uppercase tracking-tight">Verify Product</h1>
                <p class="text-gray-400 text-sm font-medium">Scan QR or enter tag number to verify authenticity.</p>
            </div>

            <!-- Scanner UI Container -->
            <div id="qr-reader-container" class="mb-10 hidden">
                <div id="qr-reader" class="overflow-hidden rounded-3xl border-4 border-[#064E3B]/10 shadow-inner bg-gray-50"></div>
                
                <div class="mt-4 flex flex-col items-center gap-4">
                    <label class="cursor-pointer text-xs font-bold text-[#064E3B] hover:text-[#10B981] transition-colors flex items-center gap-2">
                        <i class="fa-solid fa-file-image"></i>
                        <span>Or upload an image instead</span>
                        <input type="file" id="qr-input-file" accept="image/*" class="hidden">
                    </label>

                    <button type="button" id="stop-scan" class="text-xs font-black text-red-500 uppercase tracking-widest hover:text-red-700 transition-colors">
                        Stop Camera
                    </button>
                </div>
            </div>

            <form id="verifyForm" action="{{ route('consumer.search') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Tag Input with Icon -->
                <div class="relative group">
                    <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none text-gray-300 group-focus-within:text-[#10B981] transition-colors">
                        <i class="fa-solid fa-fingerprint text-xl"></i>
                    </div>
                    <input type="text" id="tag_input" name="tag_number" 
                           placeholder="TAG-XXXX-XXXX" 
                           class="w-full pl-14 pr-6 py-5 rounded-2xl bg-gray-50/50 border border-gray-100 text-center font-mono font-black text-xl uppercase tracking-[0.3em] text-[#064E3B] placeholder:text-gray-200 focus:ring-4 focus:ring-[#10B981]/10 focus:border-[#10B981] focus:bg-white outline-none transition-all shadow-inner"
                           required>
                </div>

                <!-- Primary Action Buttons -->
                <div class="grid grid-cols-1 gap-4">
                    <button type="button" id="start-scan" class="w-full bg-[#10B981] text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-sm shadow-xl shadow-[#10B981]/20 hover:bg-[#34D399] transition-all flex items-center justify-center gap-3">
                        <i class="fa-solid fa-camera"></i>
                        Open Camera Scanner
                    </button>
                    
                    <button type="submit" class="w-full bg-[#064E3B] text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-sm shadow-xl shadow-[#064E3B]/20 hover:bg-[#085F48] transition-all flex items-center justify-center gap-3">
                        <i class="fa-solid fa-magnifying-glass-chart"></i>
                        Verify Authenticity
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
                    ProductGuard™ Integrity Verification System
                </p>
            </div>
        </div>
    </div>
</x-consumer.layout>

<script>
    let html5QrCode;
    const startBtn = document.getElementById('start-scan');
    const stopBtn = document.getElementById('stop-scan');
    const fileInput = document.getElementById('qr-input-file');
    const readerContainer = document.getElementById('qr-reader-container');
    const tagInput = document.getElementById('tag_input');
    const verifyForm = document.getElementById('verifyForm');

    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Code scanned = ${decodedText}`, decodedResult);
        
        // Extract tag from URL if present
        let tag = decodedText;
        if (decodedText.includes('/passport/')) {
            tag = decodedText.split('/passport/').pop();
        }
        
        tagInput.value = tag;
        
        // Stop scanning and submit
        stopScanning().then(() => {
            verifyForm.submit();
        });
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
        
        if (!html5QrCode) {
            html5QrCode = new Html5Qrcode("qr-reader");
        }
        
        const config = { 
            fps: 15, 
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0
        };

        html5QrCode.start(
            { facingMode: "environment" }, 
            config, 
            onScanSuccess
        ).catch(err => {
            console.error("Scanner error:", err);
            alert("Camera access failed. You can still use the 'Upload Image' option below.");
            // Don't hide container, let them use file upload
        });
    });

    fileInput.addEventListener('change', e => {
        if (e.target.files.length == 0) return;
        
        const imageFile = e.target.files[0];
        if (!html5QrCode) {
            html5QrCode = new Html5Qrcode("qr-reader");
        }
        
        html5QrCode.scanFile(imageFile, true)
            .then(onScanSuccess)
            .catch(err => {
                console.error("File scan error:", err);
                alert("Could not find a valid QR code in this image.");
            });
    });

    stopBtn.addEventListener('click', stopScanning);
</script>