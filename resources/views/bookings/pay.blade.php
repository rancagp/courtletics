<x-layout>
    <x-navbar></x-navbar>
    <x-slot:title>Complete Payment - Padel Court Booking</x-slot:title>

    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-lg text-center max-w-md w-full">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Complete Your Payment</h2>
            <p class="mb-6 text-gray-600">Order ID: <strong>BOOK-{{ $booking->id }}</strong><br>Total: <strong>Rp
                    {{ number_format($booking->total_price, 0, ',', '.') }}</strong></p>

            <div class="mb-6">
                <p class="text-sm text-gray-500">Popup pembayaran akan muncul otomatis. Jika tidak, klik tombol di bawah.
                </p>
            </div>

            <button id="pay-button"
                class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-3 rounded-lg font-bold hover:shadow-lg transition transform hover:-translate-y-0.5">
                Pay Now
            </button>
        </div>
    </div>

    @php
        $isProduction = config('midtrans.isProduction');
        $snapUrl = $isProduction
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    @endphp

    <script src="{{ $snapUrl }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        const payButton = document.getElementById('pay-button');

        payButton.onclick = function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = "{{ route('booking.success', $booking->id) }}";
                },
                onPending: function(result) {
                    alert("Wating your payment!");
                    // Optional: redirect to a pending page or reload
                },
                onError: function(result) {
                    alert("Payment failed!");
                    // Optional: redirect back to retry
                },
                onClose: function() {
                    alert('You closed the popup without finishing the payment');
                }
            });
        };

        // Auto trigger on load
        window.onload = function() {
            payButton.click();
        };
    </script>
</x-layout>
