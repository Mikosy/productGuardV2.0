<aside class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0 z-10 bg-ferti-green text-white shadow-xl">
            <div class="flex-1 flex flex-col pt-8 pb-4 overflow-y-auto">
                <div class="flex items-center flex-shrink-0 px-6 mb-12">
                    <div>
                        <h1 class="text-xl font-bold tracking-tight">ADMIN PORTAL</h1>
                        <p class="text-[10px] text-green-200/60 tracking-[0.2em] uppercase font-bold">Traceability Command</p>
                    </div>
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
                
                <div class="mt-auto px-6 py-6 border-t border-white/10">
                    <div class="bg-white/5 rounded-xl p-4 mb-4">
                        <p class="text-[10px] text-green-200/50 uppercase font-bold mb-1">System Status</p>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                            <span class="text-xs font-medium text-white">Ledger Synchronized</span>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center text-sm font-medium text-green-200/70 hover:text-white transition-colors">
                            <i class="fa-solid fa-right-from-bracket mr-3"></i> Terminate Session
                        </button>
                    </form>
                </div>
            </div>
        </aside>