<x-admin-layout>
    <x-slot name="title">Tambah Lapangan</x-slot>
    <x-slot name="header">Tambah Lapangan</x-slot>

    <div class="max-w-3xl">
        <div class="bg-white rounded-lg shadow-md">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center">
                    <a href="{{ route('courts.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h2 class="text-xl font-semibold text-gray-800">Form Tambah Lapangan</h2>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('courts.store') }}" method="POST" class="p-6">
                @csrf

                <!-- Category -->
                <div class="mb-6">
                    <label for="court_category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori Lapangan <span class="text-red-500">*</span>
                    </label>
                    <select name="court_category_id" id="court_category_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('court_category_id') border-red-500 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('court_category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('court_category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Court Name -->
                <div class="mb-6">
                    <label for="court_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lapangan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="court_name" id="court_name" value="{{ old('court_name') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('court_name') border-red-500 @enderror"
                        placeholder="Contoh: Court A, Lapangan 1">
                    @error('court_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div class="mb-6">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        Lokasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('location') border-red-500 @enderror"
                        placeholder="Contoh: Lantai 2, Area Utara">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div class="mb-6">
                    <label for="price_per_hour" class="block text-sm font-medium text-gray-700 mb-2">
                        Harga per Jam (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-500">Rp</span>
                        <input type="number" name="price_per_hour" id="price_per_hour"
                            value="{{ old('price_per_hour') }}" min="0" step="1000" required
                            class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('price_per_hour') border-red-500 @enderror"
                            placeholder="150000">
                    </div>
                    @error('price_per_hour')
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
                        placeholder="Deskripsi fasilitas dan kondisi lapangan...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Maksimal 2000 karakter</p>
                </div>

                <!-- Availability -->
                <div class="mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_available" id="is_available" value="1"
                            {{ old('is_available') ? 'checked' : 'checked' }}
                            class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        <label for="is_available" class="ml-2 text-sm font-medium text-gray-700">
                            Lapangan tersedia untuk booking
                        </label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('courts.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition">
                        Simpan Lapangan
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
                            <li>Nama lapangan harus unik dan tidak boleh sama dengan lapangan lain</li>
                            <li>Pastikan kategori sudah dibuat terlebih dahulu</li>
                            <li>Lapangan tidak dapat dihapus jika masih memiliki booking aktif</li>
                            <li>Status ketersediaan dapat diubah kapan saja</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
