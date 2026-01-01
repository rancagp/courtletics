<x-layout>
    <x-navbar></x-navbar>
    <x-slot:title>Sign Up - Padel Court Booking</x-slot:title>

    <section class="bg-neutral-100 pt-[124px] min-h-screen flex items-center justify-center mb-8">
       
        <div class="container mx-auto max-w-md">
            <div class="bg-white rounded-2xl border-2 border-neutral-100 shadow-xl overflow-hidden p-6 space-y-8">
                <!-- Header -->
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-neutral-800">Signup</h1>
                </div>

                <!-- Register Form -->
                <div class="">

                    <form action="/register" method="POST">
                        @csrf

                        <!-- Full Name -->
                        <div class="mb-4">
                            <label for="name" class="inline-block text-neutral-700 font-semibold mb-2">Fullname</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-3 border-2 @error('name') border-red-500 @else border-neutral-200 @enderror rounded-lg focus:border-blue-600 focus:outline-none transition"
                                placeholder="Enter your fullname">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-neutral-700 font-semibold mb-2">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 border-2 @error('email') border-red-500 @else border-neutral-200 @enderror rounded-lg focus:border-blue-600 focus:outline-none transition"
                                placeholder="Enter your email">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-4">
                            <label for="phone" class="block text-neutral-700 font-semibold mb-2">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                                class="w-full px-4 py-3 border-2 @error('phone') border-red-500 @else border-neutral-200 @enderror rounded-lg focus:border-blue-600 focus:outline-none transition"
                                placeholder="08xx xxxx xxxx">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-neutral-700 font-semibold mb-2">Password</label>
                            <input type="password" id="password" name="password" required minlength="8"
                                class="w-full px-4 py-3 border-2 @error('password') border-red-500 @else border-neutral-200 @enderror rounded-lg focus:border-blue-600 focus:outline-none transition"
                                placeholder="Minimum 8 characters">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-neutral-700 font-semibold mb-2">Confirm
                                Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                minlength="8"
                                class="w-full px-4 py-3 border-2 @error('password_confirmation') border-red-500 @else border-neutral-200 @enderror rounded-lg focus:border-blue-600 focus:outline-none transition"
                                placeholder="Re-enter your password">
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sign Up Button -->
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold text-lg hover:shadow-2xl transition mb-4">
                            Sign Up
                        </button>

                        <!-- Login Link -->
                        <p class="text-center text-neutral-600">
                            Already have an account?
                            <a href="/login" class="text-blue-600 hover:text-blue-700 font-semibold">
                                Login
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

</x-layout>