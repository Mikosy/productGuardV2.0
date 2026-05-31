        
        
        
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard | ProductGuard</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .bg-cream { background-color: #F9F9F1; }
        .text-ferti-green { color: #1A4D2E; }
        .bg-ferti-green { background-color: #1A4D2E; }
    </style>
</head>
<body class="h-full bg-[#FAFBF8] antialiased" x-data="{ mobileMenu: false }">

    <div class="min-h-full flex">
        
        <div x-show="mobileMenu" x-cloak class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
            <div x-show="mobileMenu" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80"></div>

            <div class="fixed inset-0 flex">
                <div x-show="mobileMenu" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative mr-16 flex w-full max-w-xs flex-1">
                    
                    <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                        <button @click="mobileMenu = false" type="button" class="-m-2.5 p-2.5 text-white">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>

                    <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-ferti-green px-6 pb-4">
                        <div class="flex h-20 shrink-0 items-center border-b border-white/10">
                             <h1 class="text-white text-xl font-bold tracking-tight">ADMIN PORTAL</h1>
                        </div>
                        <nav class="mt-2 flex-1 px-4 space-y-2">
                            <x-admin.nav-link 
                                href="{{ route('admin.dashboard') }}" 
                                :active="request()->routeIs('admin.dashboard')" 
                                icon="fa-chart-pie">
                                Overview
                            </x-admin.nav-link>

                            <x-admin.nav-link 
                                href="{{ route('admin.users') }}" 
                                :active="request()->routeIs('admin.users')" 
                                icon="fa-solid fa-user mr-3 opacity-50">
                                Users
                            </x-admin.nav-link>

                            <x-admin.nav-link 
                                href="{{ route('admin.allocations.index') }}" 
                                :active="request()->routeIs('admin.allocations.index')" 
                                icon="fa-solid fa-boxes-stacked">
                                Allocations
                            </x-admin.nav-link>

                            <x-admin.nav-link 
                                href="{{ route('admin.dispatch.states') }}" 
                                :active="request()->routeIs('admin.dispatch.states')" 
                                icon="fa-solid fa-shipping-fast">
                                Dispatch
                            </x-admin.nav-link>

                            <x-admin.nav-link 
                                href="{{ route('admin.orders.index') }}" 
                                :active="request()->routeIs('admin.orders.index')" 
                                icon="fa-solid fa-shopping-cart">
                                Orders
                            </x-admin.nav-link>

                            <x-admin.nav-link 
                                href="{{ route('admin.incidents.index') }}" 
                                :active="request()->routeIs('admin.incidents.index')" 
                                icon="fa-solid fa-exclamation-triangle">
                                Incidents
                            </x-admin.nav-link>
                            
                            

                            
                            
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <x-admin.sidebar />

        <div class="lg:pl-64 flex flex-col flex-1">
            
            <x-admin.header />
            <main class="py-10 px-8">
                {{ $slot }}
            </main>

        
        </div>
    </div>

</body>
</html>