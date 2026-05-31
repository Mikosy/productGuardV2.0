<header class="sticky top-0 z-10 flex-shrink-0 flex h-20 bg-cream border-b border-gray-200/50 backdrop-blur-sm">
                <div class="flex-1 px-4 sm:px-8 flex justify-between items-center">
                    
                    <div class="flex items-center gap-4">
                        <button @click="mobileMenu = true" class="lg:hidden text-ferti-green p-2 focus:outline-none">
                            <i class="fa-solid fa-bars-staggered text-xl"></i>
                        </button>
                        <div class="hidden sm:block h-8 w-[2px] bg-ferti-green/20"></div>
                        <h2 class="text-[11px] font-black text-ferti-green tracking-[0.3em] uppercase">Integrity Ledger</h2>
                    </div>

                    <div class="flex items-center gap-6">
                        <!-- <div class="relative hidden xl:block">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input type="text" placeholder="Search ledger..." class="bg-white border-none rounded-full py-2.5 pl-9 pr-4 text-xs w-64 shadow-sm focus:ring-1 focus:ring-ferti-green">
                        </div> -->

                        <div class="flex items-center gap-3 pl-6 border-l border-gray-200" x-data="{ userMenu: false }">
                            <div class="hidden md:block text-right">
                                <p class="text-xs font-bold text-gray-900 leading-tight">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-gray-500 font-medium">System Administrator</p>
                            </div>

                            <div class="relative">
                                <button @click="userMenu = !userMenu" @click.outside="userMenu = false" class="flex items-center group focus:outline-none">
                                    <div class="w-10 h-10 rounded-full bg-ferti-green text-white flex items-center justify-center font-bold text-sm shadow-inner group-hover:brightness-110 transition-all">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                    </div>
                                    <div class="ml-2 text-ferti-green hidden sm:block">
                                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" :class="userMenu ? 'rotate-180' : ''"></i>
                                    </div>
                                </button>

                                <div x-show="userMenu" x-cloak 
                                     x-transition:enter="transition ease-out duration-100" 
                                     x-transition:enter-start="transform opacity-0 scale-95" 
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     class="absolute right-0 top-full mt-3 w-48 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 z-50">
                                    
                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-cream hover:text-ferti-green">
                                        <i class="fa-solid fa-user-gear mr-3 opacity-50"></i> Profile Settings
                                    </a>

                                    <div class="border-t border-gray-50 my-1"></div>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50">
                                            <i class="fa-solid fa-power-off mr-3 opacity-70"></i> Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>