<x-layout>
    <x-navbar />

    <main class="pt-20">
        <section class="py-12 px-4 bg-gray-50 min-h-screen">
            <div class="container mx-auto max-w-6xl">
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">
                        My Bookings ({{ $bookings->count() }})
                    </h1>
                    <p class="text-gray-600">
                        View and manage your padel court reservations
                    </p>
                </div>

                @if ($bookings->isEmpty())
                    <!-- Empty State -->
                    <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                        <div class="w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-3">No Bookings Yet</h2>
                        <p class="text-gray-600 mb-6">You haven't made any court reservations yet.</p>
                        <!-- DIUBAH: href dari "/book-court" menjadi "/#categories" -->
                        <!-- Menggunakan hash anchor untuk scroll otomatis ke section categories di home -->
                        <a href="/#categories"
                            class="inline-block bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:shadow-xl transition">
                            Book a Court Now
                        </a>
                    </div>
                @else
                    <!-- Bookings Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($bookings as $booking)
                            <div
                                class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                                <!-- Court Image -->
                                <div
                                    class="h-48 bg-gradient-to-br from-purple-500 to-indigo-600 relative overflow-hidden">
                                    @if ($booking->court && $booking->court->image)
                                        <img src="{{ asset('storage/' . $booking->court->image) }}"
                                            alt="{{ $booking->court->name }}"
                                            class="w-full h-full object-cover opacity-60">
                                    @else
                                        <img src="{{ asset('images/Padell.jpeg') }}" alt="Padel Court"
                                            class="w-full h-full object-cover">
                                    @endif
                                    <div class="absolute top-4 right-4">
                                        @if ($booking->status === 'Confirmed')
                                            <span
                                                class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                                Confirmed
                                            </span>
                                        @elseif($booking->status === 'Pending')
                                            <span
                                                class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                                Pending
                                            </span>
                                        @elseif($booking->status === 'Completed')
                                            <span
                                                class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                                Completed
                                            </span>
                                        @else
                                            <span
                                                class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                                {{ $booking->status }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Booking Info -->
                                <div class="p-6">
                                    <!-- Booking ID -->
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 uppercase tracking-wide font-semibold mb-1">
                                            Booking
                                            ID</p>
                                        <p class="text-xl font-bold text-purple-600">#{{ $booking->id }}</p>
                                    </div>

                                    <!-- Details Grid -->
                                    <div class="space-y-3">
                                        <!-- Date -->
                                        <div class="flex items-center text-gray-700">
                                            <svg class="w-5 h-5 text-purple-600 mr-3 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <div>
                                                <p class="text-xs text-gray-500">Date</p>
                                                <p class="font-semibold">
                                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Court -->
                                        <div class="flex items-center text-gray-700">
                                            <svg class="w-5 h-5 text-purple-600 mr-3 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <div>
                                                <p class="text-xs text-gray-500">Court</p>
                                                <p class="font-semibold">
                                                    {{ $booking->court ? $booking->court->name : 'Court ' . $booking->court_id }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Time -->
                                        <div class="flex items-center text-gray-700">
                                            <svg class="w-5 h-5 text-purple-600 mr-3 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div>
                                                <p class="text-xs text-gray-500">Time</p>
                                                <p class="font-semibold">
                                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} -
                                                    {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</p>
                                            </div>
                                        </div>

                                        <!-- Price -->
                                        <div class="flex items-center text-gray-700">
                                            <svg class="w-5 h-5 text-purple-600 mr-3 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <div>
                                                <p class="text-xs text-gray-500">Total Price</p>
                                                <p class="font-semibold text-green-600">Rp
                                                    {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="mt-6 pt-4 border-t border-gray-200 space-y-2">
                                        @if ($booking->status === 'Pending')
                                            <form action="{{ route('booking.check_status', $booking->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full bg-yellow-500 text-white py-2 rounded-lg font-semibold hover:bg-yellow-600 transition">
                                                    Check Payment Status
                                                </button>
                                            </form>

                                            <!-- Link to pay if needed, or just rely on check status if paid -->
                                            <!-- Optional: Link to re-pay? No, midtrans token might be expired. -->
                                        @endif

                                        <a href="{{ route('bookings.show', $booking->id) }}"
                                            class="w-full inline-block text-center bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <!-- Modal for Booking Details -->
        <div id="detailsModal"
            class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Booking Details</h2>
                        <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div id="modalContent"></div>
                </div>
            </div>
        </div>

        <script>
            function viewDetails(bookingId) {
                const modal = document.getElementById('detailsModal');
                const content = document.getElementById('modalContent');

                content.innerHTML = `
                <div class="text-center">
                    <p class="text-gray-600">Loading booking details for #${bookingId}...</p>
                    <p class="text-sm text-gray-500 mt-2">Full details feature coming soon!</p>
                </div>
            `;

                modal.classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('detailsModal').classList.add('hidden');
            }

            // Close modal when clicking outside
            document.getElementById('detailsModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });

            // Script untuk localStorage sudah tidak diperlukan
            // Karena menggunakan hash anchor (#categories) yang otomatis scroll
        </script>
</x-layout>
