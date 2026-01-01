<x-layout>
    <x-slot name="title">Profile</x-slot>

    <x-navbar />

    <div class="pt-[124px] bg-neutral-100 container mx-auto p-8">

        <div class="grid md:grid-cols-3 gap-6">

            <!-- Sidebar Profile Card -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6">
                   <div class="bg-white rounded-lg shadow-sm p-4">
                        <div class="flex items-center gap-6">
                        <!-- Avatar -->
                            <div class="flex-shrink-0">
                                <div class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-4xl font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                            </div>
                        
                            <!-- User Info -->
                            <div class="flex-1 min-w-0">
                                <h2 class="text-2xl font-bold text-neutral-900 mb-1">{{ $user->name }}</h2>
                                <p class="text-base text-neutral-500 mb-3">{{ $user->email }}</p>
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-semibold 
                                    {{ $user->isAdmin() ? 'bg-purple-500 text-purple-600' : 'bg-blue-50 text-blue-600' }}">
                                    {{ $user->role->name }}
                                </span>
                            </div>
                        </div>
                    </div>


                    
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="truncate">{{ $user->email }}</span>
                            </div>
                            @if($user->phone_number)
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>{{ $user->phone_number }}</span>
                            </div>
                            @endif
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Bergabung {{ $user->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="md:col-span-2 space-y-6">
                <!-- Edit Profile Form -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-6 border-b border-neutral-200">
                        <h3 class="text-2xl font-semibold text-neutral-900 flex items-center">Edit profile</h3>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST" class="p-6">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-neutral-800 mb-2">Full name</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                       class="w-full p-3 border border-neutral-300 rounded-lg focus:border-blue-500 @error('name') border-red-500 @enderror">
                                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-neutral-800 mb-2">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full p-3 border border-neutral-300 rounded-lg focus:border-blue-500 @error('name') border-red-500 @enderror">
                                @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-neutral-800 mb-2">Phone number</label>
                                <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                                    class="w-full p-3 border border-neutral-300 rounded-lg focus:border-blue-500 @error('name') border-red-500 @enderror">
                                @error('phone_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                    class="px-6 py-3 bg-blue-500 text-white rounded-lg font-medium 
                                         hover:bg-blue-600 shadow-md transition">Save update
                            </button>
                        </div>
                    </form>

                </div>

                <!-- Change Password Form -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-6 border-b border-neutral-200">
                        <h3 class="text-2xl font-semibold text-neutral-900 flex items-center">Change password</h3>
                        <p class="text-sm text-neutral-600 mt-1">Make sure your new password is hard to predict</p>
                    </div>

                    <form action="{{ route('profile.update-password') }}" method="POST" class="p-6">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-neutral-800 mb-2">Current password</label>
                                <input type="password" id="current_password" name="current_password" required
                                    class="w-full p-3 border border-neutral-300 rounded-lg focus:border-blue-500 @error('current_password') border-red-500 @enderror">
                                @error('current_password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- New Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-neutral-800 mb-2">New password</label>
                                <input type="password" id="password" name="password" required
                                    class="w-full p-3 border border-neutral-300 rounded-lg focus:border-blue-500 @error('current_password') border-red-500 @enderror">
                                @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                <p class="mt-2 text-xs text-gray-500">Minimal 8 characters</p>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-neutral-800 mb-2">Confirm new password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="w-full p-3 border border-neutral-300 rounded-lg focus:border-blue-500 @error('current_password') border-red-500 @enderror">
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="px-6 py-3 bg-blue-500 text-white rounded-lg font-medium 
                                         hover:bg-blue-600 shadow-md transition">Update Password
                            </button>
                        </div>
                    </form>

                </div>

            </div>

        </div>

    </div>
</x-layout>
