<x-admin-layout>
    <x-slot name="title">Edit Lapangan</x-slot>
    <x-slot name="header">Edit Lapangan: {{ $court->court_name }}</x-slot>

    <div class="max-w-3xl">
        <div class="bg-white rounded-lg shadow-md">

            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="{{ route('courts.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                            ←
                        </a>
                        <h2 class="text-xl font-semibold text-gray-800">Form Edit Lapangan</h2>
                    </div>
                    <span class="text-sm text-gray-500">ID: {{ $court->id }}</span>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('courts.update', $court->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <!-- Category -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori Lapangan
                    </label>
                    <select name="court_category_id" required
                        class="w-full px-4 py-2 border rounded-lg">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('court_category_id', $court->court_category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Court Name -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lapangan
                    </label>
                    <input type="text" name="court_name"
                        value="{{ old('court_name', $court->court_name) }}"
                        class="w-full px-4 py-2 border rounded-lg" required>
                </div>

                <!-- Location -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Lokasi
                    </label>
                    <input type="text" name="location"
                        value="{{ old('location', $court->location) }}"
                        class="w-full px-4 py-2 border rounded-lg" required>
                </div>

                <!-- Price -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Harga per Jam
                    </label>
                    <input type="number" name="price_per_hour"
                        value="{{ old('price_per_hour', $court->price_per_hour) }}"
                        class="w-full px-4 py-2 border rounded-lg" required>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-2 border rounded-lg">{{ old('description', $court->description) }}</textarea>
                </div>

                <!-- Availability -->
                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_available" value="1"
                            {{ old('is_available', $court->is_available) ? 'checked' : '' }}>
                        <span class="ml-2">Lapangan tersedia</span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-4">
                    <a href="{{ route('courts.index') }}" class="text-gray-600">Batal</a>
                    <button type="submit"
                        class="bg-purple-600 text-white px-6 py-2 rounded-lg">
                        Update Lapangan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
