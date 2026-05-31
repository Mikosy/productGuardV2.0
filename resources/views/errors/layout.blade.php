<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - ProductGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="max-w-md w-full text-center">
            <div class="mb-12">
                <span class="text-xl font-black tracking-tighter uppercase italic">Product<span class="text-[#064E3B]">Guard</span></span>
            </div>

            <div class="relative mb-8">
                <h1 class="text-[12rem] font-black text-gray-100 leading-none">@yield('code')</h1>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-32 h-32 bg-white rounded-full shadow-2xl flex items-center justify-center border border-gray-50">
                        <svg class="w-12 h-12 text-[#064E3B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @yield('icon')
                        </svg>
                    </div>
                </div>
            </div>

            <h2 class="text-3xl font-black mb-4">@yield('title')</h2>
            <p class="text-gray-500 mb-10 leading-relaxed">
                @yield('message')
            </p>

            <div class="space-y-3">
                <a href="{{ url()->previous() }}" class="block w-full py-4 bg-[#064E3B] text-white font-bold rounded-2xl hover:bg-black transition-all shadow-lg shadow-green-900/10">
                    Try Again
                </a>
                <a href="/" class="block w-full py-4 bg-white text-gray-700 font-bold rounded-2xl border border-gray-100 hover:bg-gray-50 transition-all">
                    Back to Homepage
                </a>
            </div>

            <p class="mt-16 text-xs font-medium text-gray-400 uppercase tracking-widest">
                &copy; {{ date('Y') }} ProductGuard v2.0 • Secure Infrastructure
            </p>
        </div>
    </div>
</body>
</html>