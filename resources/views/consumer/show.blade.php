<x-consumer.layout>
    <div class="max-w-4xl mx-auto py-12 px-4">
        
        <nav class="mb-8">
            <a href="{{ route('consumer.dashboard') }}" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-[#064E3B] transition-colors">
                ← Back to Marketplace
            </a>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">
            
            <div class="lg:col-span-3">
                <div class="mb-8">
                    <span class="px-3 py-1 bg-green-100 text-[#064E3B] text-[10px] font-black uppercase rounded-full tracking-wider">
                        Verified Subsidy
                    </span>
                    <h1 class="text-4xl font-black text-gray-900 mt-4 leading-tight">
                        {{ $batch->product_name }}
                    </h1>
                    <p class="text-gray-500 mt-2">Available for residents of <span class="font-bold text-gray-800">{{ auth()->user()->state }}</span></p>
                </div>

                <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Market Price</p>
                            <p class="text-2xl font-bold text-gray-300 line-through">₦{{ number_format($batch->market_price) }}</p>
                        </div>
                        <div class="h-12 w-[1px] bg-gray-100"></div>
                        <div class="text-right">
                            <p class="text-[10px] font-black uppercase text-[#064E3B] tracking-widest">Subsidized Price</p>
                            <p class="text-3xl font-black text-[#064E3B]">₦{{ number_format($batch->subsidized_price) }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-green-600 rounded-2xl py-3 px-4 flex items-center justify-center gap-3 shadow-lg shadow-green-900/10">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12z" />
                        </svg>
                        <span class="text-white text-sm font-bold">You save ₦{{ number_format($batch->market_price - $batch->subsidized_price) }} per unit</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl border border-gray-50">
                        <p class="text-[10px] font-black text-gray-400 uppercase mb-1">State Quota</p>
                        <p class="text-sm font-bold text-gray-700">{{ number_format($allocation->remaining_quota) }} units left</p>
                    </div>
                    <div class="p-4 rounded-2xl border border-gray-50">
                        <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Official Policy</p>
                        <a href="{{ $batch->news_source }}" target="_blank" class="text-xs font-bold text-[#064E3B] underline">View Source</a>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-xl sticky top-8">
                    
                    @if(session('error'))
                        <div class="mb-4 p-3 bg-red-50 text-red-600 text-xs font-bold rounded-xl border border-red-100">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-black text-gray-900 mb-6">Place Claim</h3>

                    <form action="{{ route('consumer.orders.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="allocation_id" value="{{ $allocation->id }}">

                        <div class="mb-6">
                            <label class="block text-[10px] font-black uppercase text-gray-400 tracking-widest mb-3">
                                Select Quantity
                            </label>
                            
                            @if($remainingAllowance > 0)
                                <div class="relative">
                                    <input type="number" 
                                           name="quantity" 
                                           min="1" 
                                           max="{{ $remainingAllowance }}" 
                                           value="1" 
                                           class="w-full pl-5 pr-12 py-4 bg-gray-50 border-none rounded-2xl font-bold text-lg focus:ring-2 focus:ring-[#064E3B] transition-all"
                                    >
                                    <span class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 font-bold">Units</span>
                                </div>
                                
                                <div class="mt-4 p-4 rounded-2xl bg-blue-50/50 border border-blue-100">
                                    <p class="text-[10px] text-blue-700 leading-relaxed font-medium">
                                        <strong>Limit Notice:</strong> You have <strong>{{ $remainingAllowance }}</strong> units left of your total <strong>{{ $batch->max_per_user }}</strong> user limit.
                                    </p>
                                </div>

                                <button type="submit" class="w-full mt-8 py-5 bg-[#064E3B] text-white text-sm font-black rounded-2xl shadow-lg shadow-green-900/20 hover:bg-black hover:shadow-none transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                                    PROCEED TO PAYMENT
                                </button>
                            @else
                                <div class="p-6 bg-amber-50 rounded-2xl border border-amber-100 text-center">
                                    <svg class="w-10 h-10 text-amber-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <p class="text-sm font-bold text-amber-800">Limit Reached</p>
                                    <p class="text-xs text-amber-600 mt-1">You have already claimed your maximum allowed quota for this product.</p>
                                </div>
                                <a href="{{ route('consumer.orders.index') }}" class="block text-center mt-6 text-xs font-black text-[#064E3B] uppercase tracking-widest hover:underline">
                                    View My Previous Orders
                                </a>
                            @endif
                        </div>
                    </form>

                    <p class="text-[9px] text-center text-gray-400 mt-6 leading-relaxed">
                        By proceeding, you agree that this subsidy is for personal use and cannot be resold. Secure infrastructure provided by ProductGuard v2.0.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-consumer.layout>
