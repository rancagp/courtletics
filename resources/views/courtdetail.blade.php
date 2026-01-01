<x-layout>
    <x-navbar></x-navbar>
    <x-slot:title>Book Court - Padel Court Booking</x-slot:title>

    <section class="bg-neutral-100 py-[92px] min-h-screen p-8">
    <div class=" container mx-auto">
        <!-- Main Grid: Left Content + Right Sticky Summary -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- LEFT SIDE: Scrollable Content (2 columns) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Category Card -->
                <div class="pt-8">
                    @if ($category)
                        @php
                            // Keep image mapping for aesthetics since DB might not have images
                            $images = [
                                1 => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?w=400', // Indoor
                                2 => 'https://images.unsplash.com/photo-1622163642998-1ea32b0bbc67?w=400', // Outdoor
                                3 => 'https://images.unsplash.com/photo-1622279457486-62dcc4a431d6?w=400', // Semi
                            ];
                            $bgColors = [
                                1 => 'bg-purple-50 border-purple-600',
                                2 => 'bg-green-50 border-green-600',
                                3 => 'bg-blue-50 border-blue-600',
                            ];
                            // Default fallback
                            if ($category->image) {
                                $img = Str::startsWith($category->image, 'http')
                                    ? $category->image
                                    : Storage::url($category->image);
                            } else {
                                $img = $images[$category->id] ?? 'https://via.placeholder.com/400x200';
                            }
                            $bg = $bgColors[$category->id] ?? 'bg-gray-50 border-gray-600';
                        @endphp

                        <div class="border-2 {{ $bg }} rounded-xl p-6 transition transform hover:scale-[1.02] duration-300">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold text-gray-800">{{ $category->category_name }}</h3>
                                <span class="bg-white/80 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-gray-600 shadow-sm">
                                    Premium
                                </span>
                            </div>
                            <div class="relative overflow-hidden rounded-lg mb-4 shadow-md group">
                                <img src="{{ $img }}" alt="{{ $category->category_name }}"
                                    class="w-full h-48 object-cover transform group-hover:scale-110 transition duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                                    <p class="text-white font-semibold text-sm">Best choice for professionals</p>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-3 leading-relaxed">{{ $category->description }}</p>
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>High Quality Surface</span>
                            </div>
                        </div>

                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">Kategori tidak ditemukan. Silakan pilih kategori lapangan terlebih dahulu.</p>
                            <a href="/" class="text-blue-700 font-bold hover:underline">Kembali ke Home</a>
                        </div>
                    @endif
                </div>

                <!-- Court Selection, Date & Time Slots - Combined -->
                <div class="bg-white rounded-2xl border-neutral-200 p-8 space-y-6">
                    
                  <!-- Court Select & Date - Horizontal -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Court Select -->
                        <div>
                            <label for="court_select" class="block text-lg font-semibold text-neutral-800 mb-2">Choose court</label>
                            <div class="relative">
                                <select id="court_select" name="court_id"
                                    class="w-full p-4 border-2 border-neutral-200 rounded-xl focus:border-blue-600 focus:outline-none appearance-none
                                          bg-white text-neutral-700 font-medium text-lg transition cursor-pointer hover:border-neutral-300">
                                    <option value="">Select court</option>
                                    @foreach ($courts as $court)
                                        <option value="{{ $court->id }}"
                                            data-price="{{ $court->price_per_hour }}"
                                            data-name="{{ $court->court_name }}">
                                            {{ $court->court_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-neutral-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Date Selection -->
                        <div>
                            <label for="booking_date" class="block text-lg font-semibold text-neutral-800 mb-2">Choose Date</label>
                            <input type="date" id="booking_date" name="date"
                                class="w-full p-4 border-2 border-neutral-200 rounded-xl focus:border-blue-600 focus:outline-none appearance-none
                                          bg-white text-neutral-700 font-medium text-lg transition cursor-pointer hover:border-neutral-300"
                                min="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <hr class="border-neutral-300">

                    <!-- Time Slots -->
                    <div class="space-y-3">
                        <div class="">
                            <h2 class="text-lg font-semibold text-neutral-800">Available time slots</h2>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 text-neutral-500">
                            @php
                                $timeSlots = [
                                    '06:00 - 07:00',
                                    '07:00 - 08:00',
                                    '08:00 - 09:00',
                                    '09:00 - 10:00',
                                    '10:00 - 11:00',
                                    '11:00 - 12:00',
                                    '12:00 - 13:00',
                                    '13:00 - 14:00',
                                    '14:00 - 15:00',
                                    '15:00 - 16:00',
                                    '16:00 - 17:00',
                                    '17:00 - 18:00',
                                    '18:00 - 19:00',
                                    '19:00 - 20:00',
                                    '20:00 - 21:00',
                                    '21:00 - 22:00',
                                ];
                            @endphp
                            {{-- @php
                            $disabledSlots = [];
                        
                            foreach ($bookedSlots as $booking) {
                                $start = substr($booking->start_time, 0, 5);
                                $end   = substr($booking->end_time, 0, 5);
                        
                                foreach ($timeSlots as $slot) {
                                    [$slotStart, $slotEnd] = explode(' - ', $slot);
                        
                                    if ($slotStart < $end && $slotEnd > $start) {
                                        $disabledSlots[] = $slot;
                                    }
                                }
                            }
                        @endphp --}}
                            @foreach ($timeSlots as $index => $slot)
                            @php [$slotStart, $slotEnd] = explode(' - ', $slot); @endphp
                        
                            <label class="cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="time_slot"
                                    value="{{ $slot }}"
                                    data-start="{{ $slotStart }}"
                                    data-end="{{ $slotEnd }}"
                                    class="hidden peer time-slot-checkbox"
                                >
                        
                                <div class="slot-box border-2 border-neutral-200 rounded-md p-2 text-center transition
    hover:border-neutral-300 peer-checked:bg-blue-600 
    peer-checked:border-blue-600 peer-checked:text-white">

                                    <p class="font-semibold text-sm">{{ $slot }}</p>
                                </div>
                            </label>
                        @endforeach
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button id="clear_slots_btn" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                Clear all selections
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT SIDE: Sticky Booking Summary (1 column) -->
            <div class="lg:col-span-1">
                <div class="sticky top-[124px]">
                    <div class="bg-white p-6 rounded-xl border-2 border-neutral-100 h-full">
                        <h3 class="text-xl font-semibold text-neutral-800 mb-8">Booking details</h3>

                        <div class="text-sm space-y-2 mb-4">
                            <div class="flex justify-between">
                                <span class="font-semibold text-neutral-800">Court:</span>
                                <span id="summary_court" class="text-neutral-500">Not selected</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold text-neutral-800">Date:</span>
                                <span id="summary_date" class="text-neutral-500">Not selected</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold text-neutral-800">Time Slots:</span>
                                <span id="summary_time" class="text-neutral-500">Not selected</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold text-neutral-800">Duration:</span>
                                <span id="summary_duration" class="text-neutral-500">0 hours</span>
                            </div>
                            
                        </div>
                        
                        <hr class="border-neutral-300">

                        <div class="flex justify-between items-center mt-2 py-4">
                            <span class="text-l font-semibold text-neutral-800">Total:</span>
                            <span id="summary_price" class="text-2xl font-bold text-blue-600">Rp0,00</span>
                        </div>

                        <button id="continue_btn"
                            class="w-full bg-blue-600 text-white px-8 py-4 rounded-lg font-semibold text-lg 
                            hover:bg-blue-700 hover:shadow-lg transition 
                            disabled:bg-neutral-300 disabled:text-neutral-600 
                            disabled:cursor-not-allowed" 
                            disabled>
                            Book now
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </section>

        <!-- Footer -->
    {{-- <footer class="bg-gray-900 text-gray-300">
        <div class="container mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                
                <!-- Company Info -->
                <div>
                    <h3 class="text-white text-2xl font-bold mb-6">Courtletics</h3>
                    <p class="text-gray-400 mb-6 leading-relaxed">
                        Premium padel court facilities in Bandung. Book your court easily and play with pro players.
                    </p>
                    <div class="flex gap-4">
                        <a href="https://facebook.com" target="_blank" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="https://instagram.com" target="_blank" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-pink-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="https://twitter.com" target="_blank" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-400 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-white text-lg font-semibold mb-6">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="/" class="hover:text-blue-400 transition-colors">Home</a></li>
                        <li><a href="/about" class="hover:text-blue-400 transition-colors">About Us</a></li>
                        <li><a href="/book-court" class="hover:text-blue-400 transition-colors">Book Court</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-white text-lg font-semibold mb-6">Contact Info</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-gray-400">Jl. Setiabudhi No. 123, Bandung, Jawa Barat 40164</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <a href="tel:+6222123456" class="text-gray-400 hover:text-blue-400 transition-colors">+62 22 123 456</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:info@courtletics.com" class="text-gray-400 hover:text-blue-400 transition-colors">info@courtletics.com</a>
                        </li>
                    </ul>
                </div>

                <!-- Opening Hours -->
                <div>
                    <h4 class="text-white text-lg font-semibold mb-6">Opening Hours</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex justify-between">
                            <span>Monday - Friday</span>
                            <span class="text-white font-semibold">06:00 - 22:00</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Saturday</span>
                            <span class="text-white font-semibold">06:00 - 23:00</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Sunday</span>
                            <span class="text-white font-semibold">07:00 - 22:00</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-gray-800 mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-500 text-sm">
                        © 2025 Courtletics. All rights reserved.
                    </p>
                    <div class="flex gap-6 text-sm">
                        <a href="/privacy-policy" class="text-gray-500 hover:text-blue-400 transition-colors">Privacy Policy</a>
                        <a href="/terms-of-service" class="text-gray-500 hover:text-blue-400 transition-colors">Terms of Service</a>
                        <a href="/faq" class="text-gray-500 hover:text-blue-400 transition-colors">FAQ</a>
                    </div>
                </div>
            </div>
        </div>
    </footer> --}}

    <script>
        let selectedCourtId = '';
        let selectedCourtName = '';
        let selectedPricePerHour = 0;
        let selectedDate = '';
        let selectedTimeSlots = []; // Array to store multiple time slots

        // Court selection dropdown
        const courtSelect = document.getElementById('court_select');
        const pricePreviewBox = document.getElementById('price_preview_box');
        const pricePreviewText = document.getElementById('price_preview_text');

        if (courtSelect) {
            courtSelect.addEventListener('change', function() {
                if (this.value) {
                    selectedCourtId = this.value;
                    const selectedOption = this.options[this.selectedIndex];
                    selectedCourtName = selectedOption.getAttribute('data-name');
                    selectedPricePerHour = parseInt(selectedOption.getAttribute('data-price'));

                    // Show price preview
                    if (pricePreviewBox && pricePreviewText) {
                        pricePreviewText.textContent = 'Rp ' + selectedPricePerHour.toLocaleString('id-ID');
                        pricePreviewBox.classList.remove('opacity-0', 'translate-y-2');
                    }
                } else {
                    selectedCourtId = '';
                    selectedCourtName = '';
                    selectedPricePerHour = 0;

                    // Hide price preview
                    if (pricePreviewBox) {
                        pricePreviewBox.classList.add('opacity-0', 'translate-y-2');
                    }
                }
                loadBookedSlots()
                updateSummary();
            });
        }

        // Date selection
        document.getElementById('booking_date').addEventListener('change', (e) => {
            selectedDate = e.target.value;
            loadBookedSlots();
            updateSummary();
        });

        // Time slot selection (multiple checkboxes)
        document.querySelectorAll('input[name="time_slot"]').forEach(checkbox => {
            checkbox.addEventListener('change', (e) => {
                if (e.target.checked) {
                    // Add to selected slots
                    selectedTimeSlots.push(e.target.value);
                } else {
                    // Remove from selected slots
                    selectedTimeSlots = selectedTimeSlots.filter(slot => slot !== e.target.value);
                }
                updateSummary();
            });
        });

        // Clear all selections button
        document.getElementById('clear_slots_btn').addEventListener('click', () => {
            document.querySelectorAll('input[name="time_slot"]').forEach(checkbox => {
                checkbox.checked = false;
            });
            selectedTimeSlots = [];
            updateSummary();
        });

        function updateSummary() {
            const summaryCourtEl = document.getElementById('summary_court');
            const summaryDateEl = document.getElementById('summary_date');
            const summaryTimeEl = document.getElementById('summary_time');
            const summaryDurationEl = document.getElementById('summary_duration');
            const summaryPriceEl = document.getElementById('summary_price');
            const continueBtn = document.getElementById('continue_btn');

            // Update court name
            if (selectedCourtName) {
                summaryCourtEl.textContent = selectedCourtName;
            } else {
                summaryCourtEl.textContent = 'Not selected';
            }

            // Update date
            if (selectedDate) {
                const dateObj = new Date(selectedDate);
                summaryDateEl.textContent = dateObj.toLocaleDateString('us-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            } else {
                summaryDateEl.textContent = 'Not selected';
            }

            // Update time slots
            if (selectedTimeSlots.length > 0) {
                summaryTimeEl.textContent = selectedTimeSlots.join(', ');
            } else {
                summaryTimeEl.textContent = 'Not selected';
            }

            // Update duration
            const hours = selectedTimeSlots.length;
            summaryDurationEl.textContent = hours + ' hour' + (hours !== 1 ? 's' : '');

            // Update total price
            const totalPrice = selectedPricePerHour * hours;
            if (totalPrice > 0) {
                summaryPriceEl.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
            } else {
                summaryPriceEl.textContent = 'Rp 0';
            }

            // Enable/disable continue button
            if (selectedCourtId && selectedDate && selectedTimeSlots.length > 0) {
                continueBtn.disabled = false;
            } else {
                continueBtn.disabled = true;
            }
        }

        // Continue button action
        document.getElementById('continue_btn').addEventListener('click', () => {
            if (selectedCourtId && selectedDate && selectedTimeSlots.length > 0) {
                // Calculate total price
                const totalPrice = selectedPricePerHour * selectedTimeSlots.length;

                // Encode time slots as JSON string
                const timeSlotsParam = encodeURIComponent(JSON.stringify(selectedTimeSlots));

                // Pass parameters including multiple time slots
                window.location.href =
                    `/booking-detail?court_id=${selectedCourtId}&type=${encodeURIComponent(selectedCourtName)}&date=${selectedDate}&time_slots=${timeSlotsParam}&price=${totalPrice}&hours=${selectedTimeSlots.length}`;
            }
        });

        async function loadBookedSlots() {
    if (!selectedCourtId || !selectedDate) return;

    const res = await fetch(
        `/api/booked-slots?court_id=${selectedCourtId}&date=${selectedDate}`
    );
    const bookings = await res.json();

    document.querySelectorAll('.time-slot-checkbox').forEach(cb => {
        cb.disabled = false;

        const slotStart = cb.dataset.start;
        const slotEnd   = cb.dataset.end;

        const box = cb.closest('label').querySelector('div');

        box.classList.remove(
    'bg-neutral-200',
    'border-neutral-300',
    'text-neutral-400',
    'cursor-not-allowed'
);
        bookings.forEach(b => {
            const bookedStart = b.start_time.substring(0,5);
            const bookedEnd   = b.end_time.substring(0,5);

            if (slotStart < bookedEnd && slotEnd > bookedStart) {
                cb.disabled = true;
                cb.checked = false;

                selectedTimeSlots = selectedTimeSlots.filter(slot => slot !== cb.value);

                box.classList.add(
    'bg-neutral-200',
    'border-neutral-300',
    'text-neutral-400',
    'cursor-not-allowed'
);

            }
        });
    });
}
    </script>



</x-layout>

    {{-- <!-- Price Preview Box -->
    <div id="price_preview_box"
        class="mt-6 p-4 bg-white rounded-lg border border-gray-100 shadow-sm opacity-0 
               transition-all duration-300 transform translate-y-2">
        <div class="flex justify-between items-center">
            <span class="text-gray-500 text-sm">Hourly Rate</span>
            <span id="price_preview_text" class="text-xl font-bold text-purple-600">Rp
                0</span>
        </div>
    </div> --}}