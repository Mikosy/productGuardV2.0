<x-layouts.landing :show-footer="false">
    <div class="min-h-screen flex flex-col md:flex-row bg-[#1B4332] selection:bg-[#52B788] selection:text-[#1B4332]">
        <!-- Left Side: Information & Branding -->
        <div class="flex-1 p-12 lg:p-24 flex flex-col justify-center text-white relative overflow-hidden">
            <!-- Decorative Background Element -->
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#52B788]/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-[#2D5A47]/20 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <div class="mb-10 inline-block p-4 bg-white/5 rounded-3xl border border-white/10 shadow-md">
                    <x-application-logo class="w-20 h-20 fill-current text-white drop-shadow-md" />
                </div>
                <h1 class="text-5xl font-black mb-8 leading-tight">Secure Your <br/><span class="text-[#52B788]">Supply Chain</span></h1>
                <p class="text-xl opacity-80 mb-10 max-w-md leading-relaxed">
                    Join the digital revolution in product verification. Create an account to start tracking, minting, and verifying goods across Nigeria.
                </p>
                
                <div class="space-y-6 mb-12">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-[#52B788]/20 rounded-xl flex items-center justify-center border border-[#52B788]/30">
                            <svg class="w-6 h-6 text-[#52B788]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Real-time Verification</h3>
                            <p class="text-sm opacity-60">Instantly check origin and authenticity.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-[#52B788]/20 rounded-xl flex items-center justify-center border border-[#52B788]/30">
                            <svg class="w-6 h-6 text-[#52B788]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Secure Minting</h3>
                            <p class="text-sm opacity-60">Create immutable records for your batches.</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-6">
                    <a href="{{ route('login') }}" class="text-sm font-medium opacity-70 hover:opacity-100 flex items-center gap-2 group transition-all">
                        Already have an account? 
                        <span class="group-hover:translate-x-1 transition-transform">→</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Side: Registration Form -->
        <div class="flex-1 bg-[#2D5A47] p-8 lg:p-20 flex items-center justify-center relative">
            <!-- Subtle pattern overlay -->
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4v-4H4v4H0v2h4v4h2v-4h4v-2H6zM36 4v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

            <div class="w-full max-w-lg bg-[#1B4332]/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-2xl border border-white/10 relative z-10 overflow-hidden">
                <!-- Top Accent Bar -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-transparent via-[#52B788] to-transparent"></div>

                <div class="mb-10">
                    <h2 class="text-2xl font-black text-white">Create Your Account</h2>
                    <p class="text-white/50 text-sm">Join the ProductGuard ecosystem today.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Name -->
                        <div>
                            <label class="block text-white/70 text-xs font-bold uppercase tracking-wider mb-2 ml-1">Full Name</label>
                            <input id="name" type="text" name="name" class="w-full bg-[#0F2C20] border-white/5 rounded-2xl p-4 text-white placeholder:text-white/20 focus:ring-2 focus:ring-[#52B788] transition-all" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe">
                            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs" />
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label class="block text-white/70 text-xs font-bold uppercase tracking-wider mb-2 ml-1">Email Address</label>
                            <input id="email" type="email" name="email" class="w-full bg-[#0F2C20] border-white/5 rounded-2xl p-4 text-white placeholder:text-white/20 focus:ring-2 focus:ring-[#52B788] transition-all" value="{{ old('email') }}" required autocomplete="username" placeholder="john@example.com">
                            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Role -->
                        <div>
                            <label class="block text-white/70 text-xs font-bold uppercase tracking-wider mb-2 ml-1">Your Role</label>
                            <div class="relative">
                                <select id="role" name="role" class="w-full bg-[#0F2C20] border-white/5 rounded-2xl p-4 text-white focus:ring-2 focus:ring-[#52B788] appearance-none cursor-pointer transition-all" required>
                                    <option value="admin" class="bg-[#1B4332]">Admin</option>
                                    <option value="consumer" class="bg-[#1B4332]">Consumer</option>
                                    <option value="depot_officer" class="bg-[#1B4332]">Depot Officer</option>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none opacity-50">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('role')" class="mt-1 text-xs" />
                        </div>

                        <!-- State -->
                        <div>
                            <label class="block text-white/70 text-xs font-bold uppercase tracking-wider mb-2 ml-1">State</label>
                            <input id="state" type="text" name="state" class="w-full bg-[#0F2C20] border-white/5 rounded-2xl p-4 text-white placeholder:text-white/20 focus:ring-2 focus:ring-[#52B788] transition-all" value="{{ old('state') }}" required autocomplete="state" placeholder="Lagos">
                            <x-input-error :messages="$errors->get('state')" class="mt-1 text-xs" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Password -->
                        <div>
                            <label class="block text-white/70 text-xs font-bold uppercase tracking-wider mb-2 ml-1">Password</label>
                            <input id="password" type="password" name="password" class="w-full bg-[#0F2C20] border-white/5 rounded-2xl p-4 text-white placeholder:text-white/20 focus:ring-2 focus:ring-[#52B788] transition-all" required autocomplete="new-password" placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label class="block text-white/70 text-xs font-bold uppercase tracking-wider mb-2 ml-1">Confirm Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="w-full bg-[#0F2C20] border-white/5 rounded-2xl p-4 text-white placeholder:text-white/20 focus:ring-2 focus:ring-[#52B788] transition-all" required autocomplete="new-password" placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs" />
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-[#52B788] text-[#1B4332] font-black py-5 rounded-2xl shadow-xl shadow-[#52B788]/20 hover:bg-[#74C69D] hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 uppercase tracking-widest text-sm">
                            Register Now
                        </button>
                    </div>

                    <div class="text-center pt-4">
                        <p class="text-white/40 text-sm">
                            By registering, you agree to our 
                            <a href="#" class="text-white/60 hover:text-[#52B788] underline">Terms</a> 
                            & 
                            <a href="#" class="text-white/60 hover:text-[#52B788] underline">Privacy</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.landing>
