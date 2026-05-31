<x-consumer.layout>
    <div class="max-w-7xl mx-auto py-10 px-4">
        <header class="mb-10 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-black text-gray-900">Available Subsidies</h1>
                <p class="text-gray-500">Select a product to view distribution in your region.</p>
            </div>

            <div>
                <a href="{{ route('consumer.orders.index') }}" class="block text-center mt-4 text-sm text-gray-400 font-medium">
                    Order List
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($availableProducts as $batch)
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Active</span>
                        <span class="text-gray-400 text-xs">{{ $batch->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $batch->product_name }}</h2>
                    <p class="text-sm text-gray-500 mb-6">National Allocation: {{ number_format($batch->total_quantity) }} units</p>
                    
                    <a href="{{ route('consumer.allocations.show', $batch->id) }}" 
                       class="block text-center w-full py-3 bg-[#064E3B] text-white font-bold rounded-2xl hover:bg-black transition-colors">
                        Check Availability
                    </a>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $availableProducts->links() }}
        </div>
    </div>
</x-consumer.layout>