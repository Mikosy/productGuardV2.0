<x-consumer.layout>

    @if ($errors->any())
        <div class="bg-red-50 text-red-700 p-4 rounded-2xl mb-6">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <a href="{{ url()->previous() }}" class="block text-center mt-4 text-sm text-gray-400 font-medium">
        <i class="fas fa-arrow-left"></i>
        Back
    </a>
    

    <div class="max-w-xl mx-auto py-12 px-4">
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 text-center">
            <h2 class="text-2xl font-black text-gray-900 mb-2">Final Confirmation</h2>
            <p class="text-sm text-gray-500 mb-8">Order Ref: <span class="font-mono text-[#064E3B]">{{ $order->payment_reference }}</span></p>

            <div class="bg-gray-50 rounded-2xl p-6 mb-8 text-left space-y-3">
                <div class="flex justify-between text-sm"><span class="text-gray-400">Item:</span><span class="font-bold">{{ $order->allocation->batch->product_name }}</span></div>
                <div class="flex justify-between text-sm"><span class="text-gray-400">Quantity:</span><span class="font-bold">{{ $order->quantity }} Units</span></div>
                <div class="border-t border-gray-200 my-2"></div>
                <div class="flex justify-between text-lg font-black"><span>Total:</span><span class="text-[#064E3B]">₦{{ number_format($order->amount_paid) }}</span></div>
            </div>

            <form id="paymentForm">
                <button type="button" onclick="payWithPaystack()" class="w-full py-4 bg-[#064E3B] text-white font-black rounded-2xl hover:bg-black shadow-lg shadow-green-900/20 transition-all">
                    PAY NOW
                </button>
            </form>

            <div id="error-message" class="hidden mt-4 p-3 bg-red-50 text-red-600 text-xs font-bold rounded-xl border border-red-100"></div>
        </div>
    </div>

    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script>
        function payWithPaystack() {
            let handler = PaystackPop.setup({
                key: "{{ config('services.paystack.public_key') }}", 
                email: "{{ auth()->user()->email }}",
                amount: {{ $order->amount_paid * 100 }}, // Paystack uses Kobo
                ref: "{{ $order->payment_reference }}",
                onClose: function() {
                    alert('Transaction was not completed.');
                },
                callback: function(response) {
                    // Redirect to your verification route
                    window.location.href = "{{ route('consumer.orders.verify') }}?reference=" + response.reference;
                }
            });
            handler.openIframe();
        }
    </script>
</x-consumer-layout>
