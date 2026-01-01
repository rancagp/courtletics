<x-layout>
    <x-navbar></x-navbar>
    <x-slot:title>Booking Success - Padel Court Booking</x-slot:title>

    <section class="py-12 px-4 bg-gray-50 min-h-screen flex items-center justify-center">
        <div class="container mx-auto max-w-2xl">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden text-center p-12">
                <!-- Success Icon -->
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <!-- Success Message -->
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Booking Confirmed!</h1>
                <p class="text-xl text-gray-600 mb-8">
                    Your padel court has been successfully booked.
                    We've sent a confirmation email to your inbox.
                </p>

                <!-- Booking Details -->
                <!-- Booking Details -->
<div class="bg-purple-50 rounded-xl p-6 mb-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
        Booking Details
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white rounded-lg p-4">
            <p class="text-gray-600 text-sm mb-1">Booking ID</p>
            <p class="font-bold text-lg text-purple-600">
                #PB{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
            </p>
        </div>

        <div class="bg-white rounded-lg p-4">
            <p class="text-gray-600 text-sm mb-1">Court Type</p>
            <p class="font-bold text-lg">
                {{ $booking->court->court_name }}
            </p>
        </div>

        <div class="bg-white rounded-lg p-4">
            <p class="text-gray-600 text-sm mb-1">Date</p>
            <p class="font-bold text-lg">
                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
            </p>
        </div>

        <div class="bg-white rounded-lg p-4">
            <p class="text-gray-600 text-sm mb-1">Time</p>
            <p class="font-bold text-lg">
                {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - 
                {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
            </p>
        </div>
    </div>
</div>

                <!-- What's Next -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8 text-left">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        What's Next?
                    </h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-2">1.</span>
                            Check your email for the booking confirmation and details
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-2">2.</span>
                            Arrive 10 minutes before your scheduled time
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-2">3.</span>
                            Present your booking ID at the reception
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-2">4.</span>
                            Enjoy your games!
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/"
                        class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:shadow-xl transition">
                        Back to Home
                    </a>
                </div>

                <!-- Download booking (PDF)-->
                <button onclick="window.print()"
                    class="mt-8 bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold
           hover:bg-purple-700 transition flex items-center justify-center mx-auto w-fit">
                    Cetak Booking (PDF)
                </button>
            </div>

            <!-- Help Section -->
            <div class="mt-8 text-center">
                <p class="text-gray-600 mb-2">Need help or want to make changes?</p>
                <a href="#" class="text-purple-600 hover:text-purple-700 font-semibold">
                    Contact Support
                </a>
            </div>
        </div>
    </section>

</x-layout>