
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Depot Command | ProductGuard</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAF9] min-h-screen text-gray-900 font-sans">

    <nav class="sticky top-0 z-50 bg-[#1B4332] border-b border-white/10 px-6 py-4 flex items-center justify-between shadow-lg shadow-[#1B4332]/10">
        <a href="{{ route('depot.dashboard') }}" class="flex items-center gap-3 group">
            <div class="p-2 bg-white/10 rounded-xl group-hover:bg-white/20 transition-all">
                <x-application-logo class="w-6 h-6 fill-current text-white" />
            </div>
            <span class="font-black text-xl text-white tracking-tighter uppercase">Depot Command</span>
        </a>
        
        <div class="flex items-center gap-6">
            <div class="flex flex-col items-end">
                <span class="text-[10px] font-bold text-[#52B788] uppercase tracking-widest">Active Depot</span>
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

    <main class="container mx-auto px-4 py-8">
        {{ $slot }}
    </main>

</body>
</html>