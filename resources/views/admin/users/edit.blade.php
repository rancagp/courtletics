<x-admin-layout>
    <x-slot name="title">Edit User</x-slot>
    <x-slot name="header">Edit User</x-slot>

    <div class="max-w-3xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div class="mb-6">
                    <label for="role_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select name="role_id" id="role_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('role_id') border-red-500 @enderror">
                        <option value="">-- Pilih Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}"
                                {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Divider -->
                <div class="my-6 border-t border-gray-200"></div>

                <p class="text-sm text-gray-600 mb-4">
                    <strong>Catatan:</strong> Kosongkan field password jika tidak ingin mengubahnya.
                </p>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password Baru (Opsional)
                    </label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Minimal 8 karakter</p>
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password Baru
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:shadow-lg transition font-medium">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        Perbarui
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                        class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
