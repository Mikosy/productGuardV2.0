@props(['showFooter' => true])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'ProductGuard') }} | Secure Supply Chain</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900">
        <main>
            {{ $slot }}
        </main>
        
        @if($showFooter)
            <footer class="bg-[#1B4332] text-white text-center py-8 border-t border-white/10">
                <p class="text-xs uppercase tracking-widest opacity-50">&copy; {{ date('Y') }} ProductGuard Integrity Systems</p>
            </footer>
        @endif
    </body>
</html>