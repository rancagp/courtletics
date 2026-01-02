<x-layout>
    <x-navbar></x-navbar>
    <x-slot:title>Home - Courtletics Padel Court Booking</x-slot:title>

    <!-- Hero section -->
    <section class="relative min-h-screen pt-[92px] flex items-center justify-center">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/padel.jpeg') }}" alt="Padel Court" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/50"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 text-center text-white max-w-4xl mx-auto pt-12 px-4">
            <h1 class="text-3xl md:text-6xl font-bold tracking-tight mb-3">
                Play Padel with Pro Players
            </h1>
            <p class="text-lg md:text-xl mb-8 text-white">
                Book your court in seconds—no hassle, no waiting.
            </p>

            <button onclick="document.getElementById('court-categories').scrollIntoView({ behavior: 'smooth' })"
                class="bg-blue-600 text-white px-10 md:px-12 py-3 md:py-4 rounded-lg text-base md:text-lg font-semibold transition-all duration-300 cursor-pointer shadow-sm hover:shadow-lg transform hover:scale-105 hover:bg-blue-700">
                Play now
            </button>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="court-categories" class="py-16 md:py-24 bg-neutral-50">
        <div class="container mx-auto px-4 md:px-8">
            <div class="text-center max-w-3xl mx-auto mb-10 md:mb-16">
                <h1 class="text-3xl md:text-5xl font-bold text-blue-600 mb-2 tracking-tight">
                    Choose where you want to play
                </h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @forelse($categories as $category)
                    @php
                        // Logika untuk mengambil gambar
                        if ($category->image) {
                            $imageUrl = Str::startsWith($category->image, 'http')
                                ? $category->image
                                : (Str::startsWith($category->image, 'storage/')
                                    ? asset($category->image)
                                    : Storage::url($category->image));
                        } else {
                            $firstCourt = $category->courts->first();
                            $firstImage = $firstCourt ? $firstCourt->images->first() : null;
                            $imageUrl = $firstImage
                                ? (Str::startsWith($firstImage->image_path, 'http')
                                    ? $firstImage->image_path
                                    : (Str::startsWith($firstImage->image_path, 'storage/')
                                        ? asset($firstImage->image_path)
                                        : Storage::url($firstImage->image_path)))
                                : 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800&h=500&fit=crop';
                        }
                    @endphp

                    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-neutral-100 flex flex-col h-full transform hover:-translate-y-1">
                        <div class="relative h-56 overflow-hidden">
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-all duration-300 z-10"></div>
                            <img src="{{ $imageUrl }}" alt="{{ $category->category_name }}"
                                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-neutral-900 mb-2 group-hover:text-blue-600 transition-colors">
                                {{ $category->category_name }}
                            </h3>

                            <p class="text-neutral-500 text-sm leading-relaxed mb-6 line-clamp-3 flex-grow">
                                {{ $category->description ?? 'Nikmati pengalaman bermain padel terbaik dengan fasilitas standar internasional.' }}
                            </p>

                            <div class="mt-auto pt-4 border-t border-neutral-100 flex items-center justify-between">
                                <span class="text-sm font-medium text-neutral-400">
                                    {{ $category->courts->count() }} Courts Available
                                </span>
                                <a href="/book-court?category={{ $category->id }}"
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-3 text-center py-12">
                        <div class="inline-block p-4 rounded-full bg-neutral-100 mb-4">
                            <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <p class="text-neutral-500 text-lg">Belum ada kategori lapangan yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Court Facilities --}}
    <section class="min-h-screen px-4 md:px-8 py-12 md:py-16 bg-neutral-100">
        <div class="container mx-auto">
            <div class="text-center mb-16 md:mb-16">
                <h1 class="text-3xl md:text-5xl font-bold text-blue-600 mb-2 tracking-tight">
                    Our facilities
                </h1>
                <p class="text-base md:text-xl text-neutral-500">
                    Built for players who care about comfort, on and off the court
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    class="bg-white flex-1 rounded-2xl p-6 hover:shadow-md transition border border-neutral-200 space-y-6">
                    <div class="w-14 h-14 md:w-16 md:h-16 bg-blue-50 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 md:w-8 md:h-8 text-blue-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="space-y-2">
                        <h1 class="text-lg md:text-xl font-bold text-neutral-800 tracking-tight">
                            Professional Courts
                        </h1>
                        <p class="text-neutral-500 leading-relaxed text-sm md:text-base">
                            International standard padel courts with high-quality equipment
                        </p>
                    </div>
                </div>

                <div
                    class="bg-white flex-1 rounded-2xl p-6 hover:shadow-md transition border border-neutral-200 space-y-6">
                    <div class="w-14 h-14 md:w-16 md:h-16 bg-cyan-50 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 md:w-8 md:h-8 text-cyan-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="space-y-2">
                        <h1 class="text-lg md:text-xl font-bold text-neutral-800 tracking-tight">
                            Hot & Cold Plunge
                        </h1>
                        <p class="text-neutral-500 leading-relaxed text-sm md:text-base">
                            Premium recovery facilities with hot and cold plunge pools for optimal recovery
                        </p>
                    </div>
                </div>

                <div
                    class="bg-white flex-1 rounded-2xl p-6 hover:shadow-md transition border border-neutral-200 space-y-6">
                    <div class="w-14 h-14 md:w-16 md:h-16 bg-pink-50 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 md:w-8 md:h-8 text-pink-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0
                                   012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div class="space-y-2">
                        <h1 class="text-lg md:text-xl font-bold text-neutral-800 tracking-tight">
                            Locker & Amenities
                        </h1>
                        <p class="text-neutral-500 leading-relaxed text-sm md:text-base">
                            Spacious lockers, clean showers, fluffy towels, and even hair dryers
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="min-h-screen px-4 md:px-8 py-12 md:py-16">
        <div class="max-w-7xl mx-auto space-y-16">

            {{-- Header --}}
            <div class="text-center">
                <h2 class="text-4xl md:text-5xl font-bold text-blue-600 tracking-tight mb-2">
                    Here's what people say
                </h2>
                <p class="text-neutral-500 text-xl">
                    Straight from the court, not from marketing
                </p>
            </div>

            {{-- Testimonials Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Testimonial Card 1 --}}
                <div class="flex flex-col h-full bg-white rounded-3xl p-6 shadow-sm hover:shadow-md transition-shadow gap-16">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-neutral-200 rounded-full flex-shrink-0 flex text-center
                                    font-bold text-neutral-600 items-center justify-center">AK
                        </div>
                        <div>
                            <h3 class="font-semibold text-neutral-900 text-lg">Abdul Kadir</h3>
                            <div class="flex gap-1 mt-1">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 fill-orange-400" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <p class="text-neutral-600 leading-relaxed flex-1">
                        The service is friendly and professional. Highly recommended!
                    </p>
                </div>

                <div class="flex flex-col h-full bg-white rounded-3xl p-6 shadow-sm hover:shadow-md transition-shadow gap-16">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-neutral-200 rounded-full flex-shrink-0 flex text-center
                                    font-bold text-neutral-600 items-center justify-center">AS
                        </div>
                        <div>
                            <h3 class="font-semibold text-neutral-900 text-lg">Ahmad Sadikin</h3>
                            <div class="flex gap-1 mt-1">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 fill-orange-400" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <p class="text-neutral-600 leading-relaxed flex-1">
                        Perfect place to play padel with friends and family!
                    </p>
                </div>

                <div class="flex flex-col h-full bg-white rounded-3xl p-6 shadow-sm hover:shadow-md transition-shadow gap-16">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-neutral-200 rounded-full flex-shrink-0 flex text-center
                                    font-bold text-neutral-600 items-center justify-center">OB
                        </div>
                        <div>
                            <h3 class="font-semibold text-neutral-900 text-lg">Omar Bakrie</h3>
                            <div class="flex gap-1 mt-1">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 fill-orange-400" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <p class="text-neutral-600 leading-relaxed flex-1">
                        Really can't wait to play here next week!
                    </p>
                </div>

            </div>

        </div>
    </section>

    {{-- FAQ Section --}}
    <section class="bg-white py-12 md:py-16 px-4 md:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="mb-10 md:mb-16">
                <h1 class="text-3xl md:text-5xl font-bold text-blue-600 tracking-tight text-center">
                    Frequently asked questions
                </h1>
            </div>

            <div class="space-y-4">
                <!-- FAQ Item -->
                <div
                    class="faq-item bg-neutral-50 w-full rounded-xl overflow-hidden transition-all duration-300 border-2 border-neutral-100">
                    <button
                        class="faq-question w-full px-4 md:px-6 py-4 flex justify-between items-center text-left transition-colors hover:bg-neutral-100">
                        <span class="text-base md:text-lg font-semibold text-neutral-800">
                            What are the operating hours?
                        </span>
                        <span
                            class="faq-icon text-2xl text-neutral-600 flex-shrink-0 transition-transform duration-300">+
                        </span>
                    </button>
                    <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300">
                        <div class="px-4 md:px-6 pb-4 md:pb-6 text-neutral-600 leading-relaxed text-sm md:text-base">
                            We’re open every day from 06:00 to 22:00.
                        </div>
                    </div>
                </div>

                <div
                    class="faq-item bg-neutral-50 w-full rounded-xl overflow-hidden transition-all duration-300 border-2 border-neutral-100">
                    <button
                        class="faq-question w-full px-4 md:px-6 py-4 flex justify-between items-center text-left transition-colors hover:bg-neutral-100">
                        <span class="text-base md:text-lg font-semibold text-neutral-800">
                            Is parking available at the venue?
                        </span>
                        <span
                            class="faq-icon text-2xl text-neutral-600 flex-shrink-0 transition-transform duration-300">+
                        </span>
                    </button>
                    <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300">
                        <div class="px-4 md:px-6 pb-4 md:pb-6 text-neutral-600 leading-relaxed text-sm md:text-base">
                            Yes. We provide a spacious parking area, and it's free by the way.
                        </div>
                    </div>
                </div>

                <div
                    class="faq-item bg-neutral-50 w-full rounded-xl overflow-hidden transition-all duration-300 border-2 border-neutral-100">
                    <button
                        class="faq-question w-full px-4 md:px-6 py-4 flex justify-between items-center text-left transition-colors hover:bg-neutral-100">
                        <span class="text-base md:text-lg font-semibold text-neutral-800">
                            Are rackets included in the booking?
                        </span>
                        <span
                            class="faq-icon text-2xl text-neutral-600 flex-shrink-0 transition-transform duration-300">+
                        </span>
                    </button>
                    <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300">
                        <div class="px-4 md:px-6 pb-4 md:pb-6 text-neutral-600 leading-relaxed text-sm md:text-base">
                            Yes. Every booking includes 2 rackets, and additional racket rentals are also available.
                        </div>
                    </div>
                </div>

                <div
                    class="faq-item bg-neutral-50 w-full rounded-xl overflow-hidden transition-all duration-300 border-2 border-neutral-100">
                    <button
                        class="faq-question w-full px-4 md:px-6 py-4 flex justify-between items-center text-left transition-colors hover:bg-neutral-100">
                        <span class="text-base md:text-lg font-semibold text-neutral-800">
                            Why do I need to create an account?
                        </span>
                        <span
                            class="faq-icon text-2xl text-neutral-600 flex-shrink-0 transition-transform duration-300">+
                        </span>
                    </button>
                    <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300">
                        <div class="px-4 md:px-6 pb-4 md:pb-6 text-neutral-600 leading-relaxed text-sm md:text-base">
                            An account helps us manage your bookings, send updates, and make future bookings faster.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container mx-auto px-4 md:px-20 py-12 md:py-20 text-center">
            <h1 class="text-3xl md:text-4xl text-neutral-900 font-bold mb-2">
                Ready to Play?
            </h1>
            <p class="text-base md:text-xl text-neutral-500 mb-6 mx-auto max-w-2xl">
                Book your court now and experience playing padel with pro players!
            </p>
            <button onclick="document.getElementById('court-categories').scrollIntoView({ behavior: 'smooth' })"
                class="inline-block bg-blue-600 text-white px-12 md:px-16 py-3 md:py-4 rounded-xl
                       hover:bg-blue-700 transition font-semibold text-base md:text-lg shadow-lg cursor-pointer">
                Play Now
            </button>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300">
        <div class="container mx-auto px-4 py-12 md:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 md:gap-12">
                <!-- Company Info -->
                <div>
                    <h1 class="text-white text-2xl font-bold mb-6">Courtletics</h1>
                    <p class="text-neutral-400 mb-6 leading-relaxed">
                        Premium padel court facilities in Bandung. Book your court easily and play with pro players.
                    </p>
                    <div class="flex gap-4">
                        <a href="https://facebook.com" target="_blank"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="https://instagram.com" target="_blank"
                            class="w-10 h-10 bg-gray-800
                            rounded-full flex items-center justify-center hover:bg-pink-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="https://twitter.com" target="_blank"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-400 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
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
                            <svg class="w-5 h-5 text-blue-400 mt-1 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-neutral-400">
                                Jl. Setiabudhi No. 123, Bandung, Jawa Barat 40164
                            </span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <a href="tel:+6222123456" class="text-neutral-400 hover:text-blue-400 transition-colors">
                                +62 22 123 456
                            </a>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <a href="mailto:info@courtletics.com"
                                class="text-neutral-400 hover:text-blue-400 transition-colors">
                                info@courtletics.com
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Opening Hours -->
                <div>
                    <h4 class="text-white text-lg font-semibold mb-6">Opening Hours</h4>
                    <ul class="space-y-3 text-neutral-400">
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
            <div class="border-t border-neutral-800 mt-10 md:mt-12 pt-6 md:pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-neutral-500 text-sm">
                        © 2025 Courtletics. All rights reserved.
                    </p>
                    <div class="flex flex-wrap gap-4 md:gap-6 text-sm">
                        <p class="text-neutral-500 text-sm">
                        Privacy Policy  Terms of Service  FAQ
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // FAQ Accordion functionality
        document.addEventListener('DOMContentLoaded', function() {
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                const answer = item.querySelector('.faq-answer');
                const icon = item.querySelector('.faq-icon');

                question.addEventListener('click', () => {
                    const isOpen = answer.style.maxHeight && answer.style.maxHeight !== '0px';

                    // Close all other items
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            const otherAnswer = otherItem.querySelector('.faq-answer');
                            const otherIcon = otherItem.querySelector('.faq-icon');
                            otherAnswer.style.maxHeight = '0px';
                            otherIcon.textContent = '+';
                            otherIcon.style.transform = 'rotate(0deg)';
                        }
                    });

                    // Toggle current item
                    if (isOpen) {
                        answer.style.maxHeight = '0px';
                        icon.textContent = '+';
                        icon.style.transform = 'rotate(0deg)';
                    } else {
                        answer.style.maxHeight = answer.scrollHeight + 'px';
                        icon.textContent = '−';
                        icon.style.transform = 'rotate(180deg)';
                    }
                });
            });
        });
    </script>
</x-layout>
