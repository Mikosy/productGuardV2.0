<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consumer Portal | ProductGuard</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body class="bg-[#F0FDF4] min-h-screen flex flex-col font-sans text-gray-900">

    <nav class="sticky top-0 z-50 bg-[#064E3B] border-b border-white/10 px-6 py-4 flex items-center justify-between shadow-lg shadow-[#064E3B]/10">
        <a href="{{ route('consumer.dashboard') }}" class="flex items-center gap-3 group">
            <div class="p-2 bg-white/10 rounded-xl group-hover:bg-white/20 transition-all">
                <x-application-logo class="w-6 h-6 fill-current text-white" />
            </div>
            <span class="font-black text-xl text-white tracking-tighter uppercase">Consumer Portal</span>
        </a>
        
        <div class="flex items-center gap-6">
            <div class="flex flex-col items-end text-right">
                <span class="text-[10px] font-bold text-[#10B981] uppercase tracking-widest">Verified Consumer</span>
                <span class="text-sm font-bold text-white">{{ Auth::user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white hover:bg-red-500/20 hover:text-red-400 transition-all group" title="Logout">
                    <i class="fa-solid fa-arrow-right-from-bracket text-lg"></i>
                </button>
            </form>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-4 py-8">
        {{ $slot }}
    </main>

    <footer class="bg-white border-t border-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">
                &copy; {{ date('Y') }} ProductGuard Integrity Systems — Nigeria
            </p>
        </div>
    </footer>

</body>
</html>