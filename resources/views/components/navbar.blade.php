

<nav class="w-full bg-white shadow-md flex fixed top-0 left-0 right-0 z-50">
    <div class="container mx-auto">
        <div class="p-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="/" class="w-[280px] text-2xl font-bold text-neutral-800">Courtletics</a>

            <!-- Navigation Links (Desktop) -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/"
                    class="text-neutral-400 hover:text-neutral-600 font-medium transition {{ request()->is('/') ? 'font-semibold text-neutral-800 border-b-2 border-neutral-800' : '' }}">
                    Home
                </a>
                <a href="/about"
                    class="text-neutral-400 hover:text-neutral-600 font-medium transition {{ request()->is('about') ? 'font-semibold text-neutral-800 border-b-2 border-neutral-800' : '' }}">
                    About
                </a>
                <a href="/book-court"
                    class="text-neutral-400 hover:text-neutral-600 font-medium transition {{ request()->is('book-court*') ? 'font-semibold text-neutral-800 border-b-2 border-neutral-800' : '' }}">
                    Book Court
                </a>
            </div>

            <!-- Auth (Desktop) -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-neutral-700 hover:text-blue-600 font-medium transition">
                            Admin Panel
                        </a>
                    @endif

                    <!-- Profile dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center space-x-2 text-neutral-700 hover:text-blue-600 font-medium transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                            <a href="/profile"
                                class="block w-[120px] px-4 py-2 text-neutral-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                Profile
                            </a>
                            @if (!Auth::user()->isAdmin())
                                <a href="/my-bookings"
                                    class="block w-[120px] px-4 py-2 text-neutral-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                    My Bookings
                                </a>
                            @endif
                            <hr class="my-2">
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex gap-[8px]">
                        <a href="/login"
                            class="w-[120px] border-2 border-neutral-100 text-center flex items-center justify-center bg-white text-blue-600 px-4 py-2 rounded-md font-medium hover:bg-neutral-100">
                            Login
                        </a>
                        <a href="/register"
                            class="w-[120px] flex items-center justify-center bg-blue-600 text-white px-4 py-2 rounded-md font-medium hover:bg-blue-700 shadow-lg transition">
                            Sign Up
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden text-neutral-800 focus:outline-none">
                <svg id="hamburger-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t 
               border-neutral-200 pt-2 rounded-b-lg relative z-40">
            <div class="flex flex-col p-4 space-y-4">
                <a href="/" class="text-neutral-700 hover:text-neutral-900 font-medium transition">
                    Home
                </a>
                <a href="/about" class="text-neutral-700 hover:text-neutral-900 font-medium transition">
                    About
                </a>
                <a href="/book-court" class="text-neutral-700 hover:text-neutral-900 font-medium transition">
                    Book Court
                </a>

                @auth
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-neutral-700 hover:text-blue-600 font-medium transition">
                            Admin Panel
                        </a>
                    @endif
                    <a href="/profile" class="text-neutral-700 hover:text-blue-600 font-medium transition">
                        Profile
                    </a>
                    @if (!Auth::user()->isAdmin())
                        <a href="/my-bookings" class="text-neutral-700 hover:text-blue-600 font-medium transition">
                            My Bookings
                        </a>
                    @endif
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full text-left text-red-600 hover:text-red-700 font-medium transition">
                            Logout
                        </button>
                    </form>
                @else
                <div class="w-full flex justify-between gap-4">
                    <a href="/login" class="bg-neutral-50 flex-1 text-blue-600 px-6 py-2 rounded-lg border border-neutral-300 font-medium text-center hover:bg-neutral-200">
                        Login
                    </a>
                    <a href="/register"
                        class="bg-blue-600 text-white flex-1 px-6 py-2 rounded-lg font-medium text-center hover:bg-blue-700">
                        Sign Up
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    // Ambil elemen-elemen yang diperlukan
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const hamburgerIcon = document.getElementById('hamburger-icon');
    const closeIcon = document.getElementById('close-icon');

    // Toggle mobile menu
    mobileMenuBtn.addEventListener('click', function() {
        const isHidden = mobileMenu.classList.contains('hidden');
        
        if (isHidden) {
            // Tampilkan menu
            mobileMenu.classList.remove('hidden');
            hamburgerIcon.classList.add('hidden');
            closeIcon.classList.remove('hidden');
        } else {
            // Sembunyikan menu
            mobileMenu.classList.add('hidden');
            hamburgerIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
        }
    });

    // Handle resize window
    window.addEventListener('resize', function() {
        // Jika lebar layar >= 768px (breakpoint md di Tailwind)
        if (window.innerWidth >= 768) {
            // Sembunyikan mobile menu
            mobileMenu.classList.add('hidden');
            // Reset icon ke hamburger
            hamburgerIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
        }
    });

    // Optional: Tutup menu ketika link diklik (untuk smooth UX)
    const mobileMenuLinks = mobileMenu.querySelectorAll('a');
    mobileMenuLinks.forEach(link => {
        link.addEventListener('click', function() {
            mobileMenu.classList.add('hidden');
            hamburgerIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
        });
    });
</script>