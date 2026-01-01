<x-admin-layout>
    <x-slot name="title">Tambah Kategori Lapangan</x-slot>
    <x-slot name="header">Tambah Kategori Lapangan</x-slot>

    <div class="max-w-3xl">
        <div class="bg-white rounded-lg shadow-md">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center">
                    <a href="{{ route('court-categories.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h2 class="text-xl font-semibold text-gray-800">Form Tambah Kategori</h2>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('court-categories.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6">
                @csrf

                <!-- Category Name -->
                <div class="mb-6">
                    <label for="category_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="category_name" id="category_name" value="{{ old('category_name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('category_name') border-red-500 @enderror"
                        placeholder="Contoh: Indoor, Outdoor, Premium" required>
                    @error('category_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('description') border-red-500 @enderror"
                        placeholder="Deskripsi singkat tentang kategori ini...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Maksimal 1000 karakter</p>
                </div>

                <!-- Image Upload -->
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Kategori
                    </label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('image') border-red-500 @enderror">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG, WEBP. Maks: 2MB</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('court-categories.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd" />
                </svg>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Informasi</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Nama kategori harus unik dan tidak boleh sama dengan kategori lain</li>
                            <li>Kategori ini akan digunakan untuk mengelompokkan lapangan</li>
                            <li>Kategori tidak dapat dihapus jika masih digunakan oleh lapangan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
