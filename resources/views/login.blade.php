<x-layout>
    <x-navbar></x-navbar>
    <x-slot:title>Login - Padel Court Booking</x-slot:title>

    <section class="bg-neutral-100 pt-[92px] min-h-screen flex items-center justify-center">
        
        <div class="container mx-auto max-w-md">
            <div class="bg-white rounded-2xl border-2 border-neutral-100 shadow-xl overflow-hidden p-6 space-y-8">

                <!-- Header -->
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-neutral-800">Login</h1>
                </div>

                <!-- Login Form -->
                <div class="">
                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <form action="/login" method="POST">
                        @csrf

                        <!-- Email -->
                        <div class="mb-6">
                            <label for="email" class="block text-neutral-700 font-semibold mb-2">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 border-2 @error('email') border-red-600 @else border-neutral-200 @enderror rounded-lg focus:border-blue-600 outline-none transition"
                                placeholder="Enter your email">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-12">
                            <label for="password" class="block text-neutral-700 font-semibold mb-2">Password</label>
                            <input type="password" id="password" name="password" required
                                class="w-full px-4 py-3 border-2 @error('password') border-red-600 @else border-neutral-200 @enderror rounded-lg focus:border-blue-600 focus:outline-none transition"
                                placeholder="Enter your password">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <!-- Login Button -->
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold text-lg hover:bg-blue-700 transition mb-4">
                            Login
                        </button>                    

                        <!-- Sign Up Link -->
                        <p class="text-center text-gray-600">
                            Don't have an account?
                            <a href="/register" class="text-blue-500 hover:text-blue-600 font-medium">
                                Sign Up
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

</x-layout>