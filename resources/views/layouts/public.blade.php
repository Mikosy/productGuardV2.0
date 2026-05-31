<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Public Verification | ProductGuard</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-[#F8FAFC] min-h-screen text-gray-900 font-sans antialiased">
    <nav class="sticky top-0 z-50 bg-[#1E40AF] border-b border-white/10 px-6 py-4 flex items-center justify-between shadow-lg shadow-blue-900/10 mb-8">
        <div class="max-w-md mx-auto w-full flex justify-between items-center">
            <div class="flex items-center gap-2">
                <x-application-logo class="w-6 h-6 fill-current text-white" />
                <span class="font-black text-lg tracking-tighter text-white uppercase">ProductGuard</span>
            </div>
            <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-blue-200">
                <i class="fa-solid fa-shield-check"></i>
            </div>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-6 pb-20">
        @yield('content')
    </main>

    <footer class="text-center py-10 text-gray-400 text-[10px] uppercase tracking-[0.3em] border-t border-gray-100 mt-10">
        &copy; {{ date('Y') }} ProductGuard Integrity — Secure Public Ledger
    </footer>
</body>
</html>