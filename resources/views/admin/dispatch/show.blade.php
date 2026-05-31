<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Dispatch Tags - {{ $state }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { background: white; color: black; }
            .no-print { display: none !important; }
            .print-card { 
                page-break-after: always; 
                box-shadow: none !important; 
                border: 2px solid #000 !important;
                margin: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <div class="no-print bg-white border-b border-gray-200 sticky top-0 z-50 px-8 py-4 flex items-center justify-between shadow-sm">
        <div>
            <a href="{{ route('admin.dispatch.states') }}" class="text-xs font-bold text-gray-400 hover:text-black uppercase tracking-widest">← Back to States</a>
            <h2 class="text-lg font-black text-gray-800 mt-1">Printing {{ $items->count() }} Tags for <span class="text-[#064E3B]">{{ $state }}</span></h2>
        </div>
        <button onclick="window.print()" class="px-6 py-3 bg-[#064E3B] text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-black transition-all">
            🖨️ Trigger Printer Window
        </button>
    </div>

    <div class="max-w-2xl mx-auto py-12 px-4 space-y-8">
        @foreach($items as $item)
            <div class="print-card bg-white border border-gray-200 rounded-3xl p-8 shadow-md flex items-center gap-8 relative overflow-hidden bg-white">
                
                <div class="flex-shrink-0 border-2 border-gray-50 p-2 rounded-2xl bg-white">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $item->item_tracking_id }}&color=064E3B" 
                         alt="Item Serial QR Code" 
                         class="w-[130px] h-[130px]" 
                         loading="lazy">
                </div>

                <div class="flex-grow space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[9px] font-black uppercase tracking-widest bg-gray-100 text-gray-600 px-2 py-0.5 rounded">
                            {{ $item->order->allocation->batch->product_name ?? 'Subsidized Cargo' }}
                        </span>
                    </div>

                    <h3 class="text-xl font-black text-gray-900 font-mono tracking-tight">{{ $item->item_tracking_id }}</h3>
                    
                    <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-xs pt-2 border-t border-gray-100">
                        <div>
                            <p class="text-[9px] uppercase text-gray-400 font-bold">Beneficiary</p>
                            <p class="font-bold text-gray-700 truncate">{{ $item->order->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] uppercase text-gray-400 font-bold">Target Destination</p>
                            <p class="font-bold text-gray-700">{{ $state }} Warehouse</p>
                        </div>
                    </div>
                </div>

                <div class="absolute right-4 bottom-4 text-[8px] font-bold tracking-widest text-gray-300 uppercase select-none">
                    ProductGuard v2.0
                </div>
            </div>
        @endforeach
    </div>

</body>
</html>