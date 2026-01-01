<x-layout>
    <x-navbar></x-navbar>
    <x-slot:title>Booking Details - Padel Court Booking</x-slot:title>

    <section class="bg-neutral-100 py-[124px] min-h-screen">
        <div class="container justify-between px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-x-8">

                <!-- Booking Form -->
                <div class="lg:col-span-2">
                    <form action="{{ route('payment.process') }}" method="POST" id="booking_form" class="bg-white rounded-2xl p-8">
                        @csrf
                        <input type="hidden" name="court_id" value="{{ request('court_id') }}">
                    
                        @php
                            // --- LOGIKA PARSING WAKTU (FIXED) ---
                            $startTime = ''; 
                            $endTime = '';
                            $duration = 1;
                            $displayTime = '';
                    
                            // 1. Cek apakah ada time_slots (Array JSON dari URL - Logic Baru)
                            if (request('time_slots')) {
                                $slots = json_decode(urldecode(request('time_slots')), true);
                                
                                if (is_array($slots) && count($slots) > 0) {
                                    $duration = count($slots); // Hitung durasi
                                    
                                    // Ambil slot pertama untuk Start Time
                                    $firstSlot = $slots[0];
                                    $partsStart = explode('-', $firstSlot);
                                    $startTime = trim($partsStart[0]); 
                    
                                    // Ambil slot terakhir untuk Display End Time
                                    $lastSlot = end($slots);
                                    $partsEnd = explode('-', $lastSlot);
                                    $lastTime = trim($partsEnd[1]);
                                    
                                    $displayTime = $startTime . ' - ' . $lastTime;
                                }
                            } 
                            // 2. Fallback jika single slot (Logic Lama/Backup)
                            elseif (request('time')) {
                                $timeSlot = request('time');
                                if (str_contains($timeSlot, '-')) {
                                    $parts = explode('-', $timeSlot);
                                    $startTime = trim($parts[0]);
                                    $displayTime = $timeSlot;
                                } else {
                                    $startTime = $timeSlot;
                                    $displayTime = $timeSlot;
                                }
                            }
                        @endphp
                    
                        <input type="hidden" name="court_type" value="{{ request('court_id') }}">
                        <input type="hidden" name="booking_date" value="{{ request('date') }}">
                        
                        {{-- PERBAIKAN UTAMA DI SINI (Baris 58): Gunakan $startTime --}}
                        <input type="hidden" name="start_time" value="{{ $startTime }}">
                        
                        {{-- Input hidden hours wajib ada --}}
                        <input type="hidden" name="hours" value="{{ $duration }}">
                        
                        <input type="hidden" name="players" value="{{ request('players') }}">
                        <input type="hidden" name="total_price" value="{{ request('price') }}">
                        <input type="hidden" name="payment_method" value="midtrans">
                    
                        <div class="space-y-1 mb-6">
                            <h1 class="text-2xl font-semibold text-neutral-800 tracking-tight">Fill personal information</h1>
                            <p class="text-neutral-500">Complete your personal information to confirm the booking</p>
                        </div>
                    
                        <div class="mb-6">
                            <label for="full_name" class="block text-neutral-700 font-semibold mb-2">Full name</label>
                            <input type="text" id="full_name" name="customer_name" required
                                value="{{ old('customer_name', auth()->check() ? auth()->user()->name : '') }}"
                                class="w-full px-3 py-3 border-2 border-neutral-200 rounded-lg focus:border-blue-600 focus:outline-none"
                                placeholder="Enter your full name">
                        </div>
                    
                        <div class="mb-6">
                            <label for="email" class="block text-neutral-700 font-semibold mb-2">Email</label>
                            <input type="email" id="email" name="customer_email" required
                                value="{{ old('customer_email', auth()->check() ? auth()->user()->email : '') }}"
                                class="w-full px-3 py-3 border-2 border-neutral-200 rounded-lg focus:border-blue-600 focus:outline-none"
                                placeholder="Enter your email">
                        </div>
                    
                        <div class="mb-6">
                            <label for="phone" class="block text-neutral-700 font-semibold mb-2">Phone number</label>
                            <input type="tel" id="phone" name="customer_phone" required
                                value="{{ old('customer_phone', auth()->check() ? auth()->user()->phone_number : '') }}"
                                class="w-full px-3 py-3 border-2 border-neutral-200 rounded-lg focus:border-blue-600 focus:outline-none"
                                placeholder="08xx xxxx xxxx">
                        </div>
                    
                        <div class="mb-6">
                            <label for="notes" class="block text-neutral-700 font-semibold mb-2">Notes (optional)</label>
                            <textarea id="notes" name="notes" rows="4"
                                class="w-full px-3 py-3 border-2 border-neutral-200 rounded-lg focus:border-blue-600 focus:outline-none"
                                placeholder="Let us know if you have some requests"></textarea>
                        </div>
                    
                        <div class="mb-8">
                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" id="terms" name="terms" required
                                    class="w-4 h-4 text-blue-600 border-neutral-300 rounded">
                                <span class="ml-3 text-neutral-700">I agree to the <a href="#"
                                        class="text-blue-600 cursor pointer">Terms and Conditions</a>
                                    and <a href="#" class="text-blue-600 cursor pointer">Cancellation Policy</a></span>
                            </label>
                        </div>
                    </form>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl p-8 sticky top-24">

                        <h2 class="text-2xl font-semibold text-neutral-800 mb-4 tracking-tight">Booking details</h2>

                        <div class="mb-6">
                            <!-- Court Type -->
                            <div class="flex justify-between items-center py-1">
                                <span class="text-neutral-500">Court</span>
                                <span class="text-neutral-800 text-medium">
                                    {{ ucfirst(request('type')) }}
                                </span>
                            </div>

                            <!-- Date -->
                            <div class="flex justify-between items-center py-1">
                                <span class="text-neutral-500">Date</span>
                                <span class="text-neutral-800 text-medium">
                                    {{ \Carbon\Carbon::parse(request('date'))->format('d M Y') }}
                                </span>
                            </div>

                            <!-- Time -->
                            <div class="flex justify-between items-center py-1">
                                <span class="text-neutral-500">Time</span>
                                <span class="text-neutral-800 text-medium">
                                    {{ $displayTime }}
                                </span>
                            </div>

                            <!-- Duration -->
                            <div class="flex justify-between items-center py-1">
                                <span class="text-neutral-500">Duration</span>
                                <span class="text-neutral-800 text-medium">
                                    {{ $duration }} Hours
                                </span>
                            </div>

                        <!-- Price Breakdown -->
                        <div class="mb-4">
                            <div class="flex justify-between items-center py-1">
                                <span class="text-neutral-500">Subtotal</span>
                                <span class="font-semibold text-neutral-700">Rp
                                    {{ number_format(request('price'), 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-1">
                                <span class="text-neutral-500">Service fee</span>
                                <span class="font-semibold text-neutral-700">Rp
                                    {{ number_format(request('price') * 0.05, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <hr class="border-neutral-300 mb-4">

                        <div class="mb-4">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-neutral-900">Total</span>
                                <span class="text-2xl font-bold text-blue-600">
                                    Rp {{ number_format(request('price') * 1.05, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>


                        <!-- Submit Button -->
                        <div class="mt-6">
                            <button type="submit" form="booking_form"
                                class="w-full bg-blue-500 text-white py-4 rounded-lg font-bold text-lg hover:bg-blue-600 shadow-md transition">
                                Continue payment
                            </button>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layout>
