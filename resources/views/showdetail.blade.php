<x-layout>
    <x-navbar />

    <main class="pt-20">
        <section class="py-12 px-4 bg-gray-50 min-h-screen">
            <div class="container mx-auto max-w-3xl bg-white rounded-2xl shadow-lg p-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">
                    Booking #{{ $booking->id }}
                </h1>

                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500">Date</p>
                        <p class="font-semibold">
                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Court</p>
                        <p class="font-semibold">
                            {{ $booking->court ? $booking->court->name : 'Court ' . $booking->court_id }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Time</p>
                        <p class="font-semibold">
                            {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Total Price</p>
                        <p class="font-semibold text-green-600">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Status</p>
                        <p class="font-semibold">{{ $booking->status }}</p>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ url('/my-bookings') }}"
                        class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700">
                        Back to My Bookings
                    </a>
                </div>
            </div>
        </section>
    </main>
</x-layout>
