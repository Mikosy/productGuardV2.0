<x-admin.layout>
<div class="max-w-5xl mx-auto pb-20">
    <!-- Breadcrumb & Header -->
    <div class="mb-10">
        <a href="{{ route('admin.allocations.index') }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-ferti-green transition-colors mb-4 group">
            <i class="fa-solid fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
            Back to Allocations
        </a>
        <h1 class="text-3xl font-black text-gray-900 tracking-tight">New Federal Allocation</h1>
        <p class="text-gray-500 mt-1">Register a new government subsidy and distribute state quotas across the federation.</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-2xl mb-10 animate-pulse">
            <div class="flex items-center mb-2">
                <i class="fa-solid fa-circle-exclamation text-red-500 mr-2"></i>
                <h3 class="text-red-800 font-bold">Please correct the following errors:</h3>
            </div>
            <ul class="list-disc list-inside text-red-700 text-sm space-y-1 ml-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.allocations.store') }}" method="POST" class="space-y-12">
        @csrf

        <!-- Section 1: General Information -->
        <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-8 py-6 bg-gray-50/50 border-b border-gray-50 flex items-center gap-4">
                <div class="w-10 h-10 bg-ferti-green text-white rounded-xl flex items-center justify-center font-black">1</div>
                <div>
                    <h2 class="font-bold text-gray-900">General Information</h2>
                    <p class="text-xs text-gray-500">Basic details about the product and national totals.</p>
                </div>
            </div>
            
            <div class="p-8 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700">Product Name</label>
                        <div class="relative group">
                            <i class="fa-solid fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-ferti-green transition-colors"></i>
                            <input type="text" name="product_name" value="{{ old('product_name') }}" placeholder="e.g. Urea Fertilizer" class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border-gray-100 rounded-2xl focus:ring-ferti-green focus:border-ferti-green focus:bg-white transition-all outline-none" required>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700">Total National Quantity</label>
                        <div class="relative group">
                            <i class="fa-solid fa-cubes absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-ferti-green transition-colors"></i>
                            <input type="number" name="total_quantity" value="{{ old('total_quantity') }}" placeholder="e.g. 1000000" class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border-gray-100 rounded-2xl focus:ring-ferti-green focus:border-ferti-green focus:bg-white transition-all outline-none" required>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700">Market Price (₦)</label>
                        <input type="number" name="market_price" value="{{ old('market_price') }}" placeholder="1,000,000" class="w-full px-4 py-3.5 bg-gray-50 border-gray-100 rounded-2xl focus:ring-ferti-green focus:border-ferti-green focus:bg-white transition-all outline-none" required>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700">Subsidized Price (₦)</label>
                        <input type="number" name="subsidized_price" value="{{ old('subsidized_price') }}" placeholder="500,000" class="w-full px-4 py-3.5 bg-gray-50 border-gray-100 rounded-2xl focus:ring-ferti-green focus:border-ferti-green focus:bg-white transition-all outline-none" required>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700">Max per User</label>
                        <input type="number" name="max_per_user" value="{{ old('max_per_user', 50) }}" placeholder="50" class="w-full px-4 py-3.5 bg-gray-50 border-gray-100 rounded-2xl focus:ring-ferti-green focus:border-ferti-green focus:bg-white transition-all outline-none" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Official News Source (URL)</label>
                    <div class="relative group">
                        <i class="fa-solid fa-link absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-ferti-green transition-colors"></i>
                        <input type="url" name="news_source" value="{{ old('news_source') }}" placeholder="https://statehouse.gov.ng/news/..." class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border-gray-100 rounded-2xl focus:ring-ferti-green focus:border-ferti-green focus:bg-white transition-all outline-none">
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: State Quotas -->
        <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-8 py-6 bg-gray-50/50 border-b border-gray-50 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-amber-500 text-white rounded-xl flex items-center justify-center font-black">2</div>
                    <div>
                        <h2 class="font-bold text-gray-900">Distribution by State</h2>
                        <p class="text-xs text-gray-500">Allocate specific quotas to each of the 36 states and FCT.</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-2 text-[10px] font-black uppercase text-gray-400">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Values are in units</span>
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($states as $state)
                    <div class="p-4 border border-gray-50 rounded-2xl bg-gray-50/30 hover:bg-white hover:border-ferti-green/20 hover:shadow-sm transition-all group">
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 group-hover:text-ferti-green transition-colors">{{ $state }}</label>
                        <input type="number" 
                               name="quotas[{{ $state }}]" 
                               value="{{ old('quotas.'.$state, 100) }}" 
                               class="w-full border-gray-100 rounded-xl text-sm font-bold focus:ring-ferti-green focus:border-ferti-green bg-white py-2"
                               required>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-between p-8 bg-ferti-green rounded-[2rem] shadow-xl shadow-ferti-green/20">
            <div class="text-white hidden md:block">
                <p class="text-sm font-bold opacity-80">Ready to publish?</p>
                <p class="text-xs opacity-60">This will immediately update state inventory across the portal.</p>
            </div>
            <button type="submit" class="w-full md:w-auto px-12 py-5 bg-white text-ferti-green font-black rounded-2xl shadow-lg hover:bg-black hover:text-white transition-all flex items-center justify-center gap-3">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                Publish Allocation Batch
            </button>
        </div>
    </form>
</div>
</x-admin.layout>