<x-layouts.landing>
    <!-- Navigation Bar -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    <x-application-logo class="w-10 h-10 fill-current text-[#1B4332]" />
                    <span class="text-xl font-black tracking-tighter text-[#1B4332]">ProductGuard</span>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="rounded-xl bg-[#1B4332] px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-[#1B4332]/20 hover:bg-[#2D5A47] transition-all">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-700 hover:text-[#1B4332]">Log In</a>
                        <a href="{{ route('register') }}" class="rounded-xl bg-[#1B4332] px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-[#1B4332]/20 hover:bg-[#2D5A47] transition-all">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-white pt-16 pb-32">
        <!-- Decorative background elements -->
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-[800px] h-[800px] bg-[#52B788]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-[#1B4332]/5 rounded-full blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#52B788]/10 text-[#1B4332] text-xs font-bold uppercase tracking-widest mb-8 border border-[#52B788]/20">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#52B788] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#52B788]"></span>
                </span>
                Trust Secured in Real-Time
            </div>
            <h1 class="text-5xl font-black tracking-tight text-gray-900 sm:text-7xl leading-[1.1] mb-8">
                The Digital Passport for <br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#1B4332] to-[#52B788]">Supply Chain Integrity</span>
            </h1>
            <p class="mx-auto max-w-2xl text-lg leading-8 text-gray-600 mb-12">
                Ensure authenticity from production to the final consumer. ProductGuard provides an immutable record for every essential good in the Nigerian market.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="{{ route('register') }}" class="w-full sm:w-auto rounded-2xl bg-[#1B4332] px-10 py-5 text-base font-black text-white shadow-xl shadow-[#1B4332]/20 hover:bg-[#2D5A47] hover:-translate-y-1 transition-all">Start Tracking Now</a>
                <button class="flex items-center gap-3 text-gray-900 font-bold hover:text-[#1B4332] group transition-colors">
                    <div class="w-12 h-12 rounded-full border border-gray-200 flex items-center justify-center group-hover:border-[#1B4332] transition-colors">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                    Watch Demo
                </button>
            </div>

            <!-- Stats -->
            <div class="mt-24 grid grid-cols-2 md:grid-cols-4 gap-8 border-t border-gray-100 pt-16">
                <div>
                    <p class="text-3xl font-black text-[#1B4332]">100%</p>
                    <p class="text-sm text-gray-500 font-medium">Immutable Records</p>
                </div>
                <div>
                    <p class="text-3xl font-black text-[#1B4332]">36</p>
                    <p class="text-sm text-gray-500 font-medium">States Covered</p>
                </div>
                <div>
                    <p class="text-3xl font-black text-[#1B4332]">Real-time</p>
                    <p class="text-sm text-gray-500 font-medium">Tracking Speed</p>
                </div>
                <div>
                    <p class="text-3xl font-black text-[#1B4332]">Secure</p>
                    <p class="text-sm text-gray-500 font-medium">Authentication</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="bg-gray-50 py-32 relative">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center mb-20">
                <h2 class="text-base font-bold leading-7 text-[#52B788] uppercase tracking-widest mb-4">Core Ecosystem</h2>
                <p class="text-4xl font-black tracking-tight text-gray-900 sm:text-5xl">Everything you need to track assets</p>
                <p class="mt-6 text-lg text-gray-600 leading-relaxed">A complete suite of tools designed for transparency and accountability in the distribution of essential goods.</p>
            </div>
            
            <div class="mx-auto grid max-w-2xl grid-cols-1 gap-8 sm:gap-12 lg:max-w-none lg:grid-cols-3">
                <!-- Feature 1 -->
                <div class="group relative bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-2xl hover:shadow-[#1B4332]/5 hover:-translate-y-2 transition-all duration-300">
                    <div class="w-16 h-16 bg-[#1B4332]/5 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-[#1B4332] transition-colors duration-300">
                        <svg class="w-8 h-8 text-[#1B4332] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 mb-4">Secure Minting</h3>
                    <p class="text-gray-600 leading-relaxed">Admins create immutable digital records for every batch, generating unique, tamper-proof digital identities.</p>
                </div>

                <!-- Feature 2 -->
                <div class="group relative bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-2xl hover:shadow-[#1B4332]/5 hover:-translate-y-2 transition-all duration-300">
                    <div class="w-16 h-16 bg-[#1B4332]/5 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-[#1B4332] transition-colors duration-300">
                        <svg class="w-8 h-8 text-[#1B4332] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 mb-4">Depot Verification</h3>
                    <p class="text-gray-600 leading-relaxed">Field officers confirm arrivals at the state level, signing off on deliveries with multi-factor digital proof.</p>
                </div>

                <!-- Feature 3 -->
                <div class="group relative bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-2xl hover:shadow-[#1B4332]/5 hover:-translate-y-2 transition-all duration-300">
                    <div class="w-16 h-16 bg-[#1B4332]/5 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-[#1B4332] transition-colors duration-300">
                        <svg class="w-8 h-8 text-[#1B4332] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 mb-4">Digital Passports</h3>
                    <p class="text-gray-600 leading-relaxed">Consumers scan or search items to verify origin, market price, and authenticity instantly via the digital passport.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- How it Works -->
    <div id="how-it-works" class="py-32 bg-white overflow-hidden">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <div>
                    <h2 class="text-base font-bold leading-7 text-[#52B788] uppercase tracking-widest mb-4 text-left">Process Flow</h2>
                    <h2 class="text-4xl font-black text-gray-900 mb-8 leading-tight">Transparency from <br/><span class="text-[#1B4332]">End to End</span></h2>
                    
                    <div class="space-y-10">
                        <div class="flex gap-6">
                            <div class="flex-none w-12 h-12 rounded-2xl bg-[#1B4332] text-white flex items-center justify-center font-black">1</div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">Mint Digital Identity</h4>
                                <p class="text-gray-600">Goods are recorded in the system at the point of entry or manufacture, creating a unique cryptographic tag.</p>
                            </div>
                        </div>
                        <div class="flex gap-6">
                            <div class="flex-none w-12 h-12 rounded-2xl bg-[#1B4332] text-white flex items-center justify-center font-black">2</div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">State-Level Checkpoint</h4>
                                <p class="text-gray-600">Officers verify the batch at designated depots, updating the digital record with timestamp and location data.</p>
                            </div>
                        </div>
                        <div class="flex gap-6">
                            <div class="flex-none w-12 h-12 rounded-2xl bg-[#1B4332] text-white flex items-center justify-center font-black">3</div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">Consumer Verification</h4>
                                <p class="text-gray-600">End-users scan the product to confirm its entire journey and verify they are holding a genuine item.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-[#1B4332] to-[#52B788] rounded-[3rem] rotate-3 opacity-10"></div>
                    <div class="relative bg-gray-900 rounded-[3rem] p-4 shadow-2xl overflow-hidden aspect-[4/3] flex items-center justify-center">
                        <x-application-logo class="w-32 h-32 text-white/20" />
                        <div class="absolute bottom-10 left-10 right-10 p-6 bg-white/10 backdrop-blur-md rounded-2xl border border-white/10">
                            <div class="flex items-center gap-4 mb-2">
                                <div class="w-2 h-2 rounded-full bg-[#52B788]"></div>
                                <span class="text-white text-xs font-bold uppercase tracking-widest">Active Verification</span>
                            </div>
                            <div class="h-2 w-full bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full w-[70%] bg-[#52B788] animate-pulse"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-[#1B4332] py-24 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4v-4H4v4H0v2h4v4h2v-4h4v-2H6zM36 4v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        <div class="mx-auto max-w-7xl px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl font-black text-white sm:text-5xl mb-8 leading-tight">Ready to Secure the <br/>Nigerian Market?</h2>
            <p class="mx-auto max-w-xl text-lg text-white/70 mb-12">Join hundreds of companies and thousands of consumers using ProductGuard to eliminate counterfeit goods.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="{{ route('register') }}" class="w-full sm:w-auto bg-[#52B788] text-[#1B4332] px-10 py-5 rounded-2xl font-black shadow-xl shadow-[#52B788]/20 hover:bg-[#74C69D] transition-all">Create Free Account</a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto bg-white/5 backdrop-blur-md text-white border border-white/20 px-10 py-5 rounded-2xl font-black hover:bg-white/10 transition-all">Access Dashboard</a>
            </div>
        </div>
    </div>
</x-layouts.landing>