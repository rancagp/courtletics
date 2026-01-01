<x-admin-layout>
    <x-slot name="title">Manajemen Lapangan</x-slot>
    <x-slot name="header">Manajemen Lapangan</x-slot>

    <div class="bg-white rounded-lg shadow-md">
        <!-- Header Section with Filters -->
        <div class="p-6 border-b border-gray-200">
            <form method="GET" action="{{ route('courts.index') }}" id="searchForm" class="space-y-4">
                <div class="flex flex-col md:flex-row md:items-end gap-4">
                    <!-- Search -->
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari Lapangan</label>
                        <div class="relative">
                            <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                                placeholder="Cari nama atau lokasi..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Filter Kategori -->
                    <div class="w-full md:w-48">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category_id" id="categorySelect"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Ketersediaan -->
                    <div class="w-full md:w-48">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ketersediaan</label>
                        <select name="is_available" id="availabilitySelect"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('is_available') == '1' ? 'selected' : '' }}>
                                Tersedia
                            </option>
                            <option value="0" {{ request('is_available') == '0' ? 'selected' : '' }}>
                                Tidak Tersedia
                            </option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-2">
                        <button type="submit"
                            class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition">
                            Filter
                        </button>
                        <a href="{{ route('courts.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition">
                            Reset
                        </a>
                        <!-- Export PDF Button -->
                        <a href="{{ route('courts.exportPdf', request()->all()) }}" target="_blank"
                            class="flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            PDF
                        </a>
                    </div>
                </div>
            </form>

            <!-- Add Button -->
            <div class="mt-4">
                <a href="{{ route('courts.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Lapangan
                </a>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto" id="courts-table-container">
            @include('admin.courts.table')
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.querySelector('input[name="search"]');
                const categorySelect = document.querySelector('select[name="category_id"]');
                const availabilitySelect = document.querySelector('select[name="is_available"]');
                const tableContainer = document.getElementById('courts-table-container');

                // Debounce function
                function debounce(func, wait) {
                    let timeout;
                    return function executedFunction(...args) {
                        const later = () => {
                            clearTimeout(timeout);
                            func(...args);
                        };
                        clearTimeout(timeout);
                        timeout = setTimeout(later, wait);
                    };
                }

                function fetchCourts() {
                    const search = searchInput.value;
                    const category = categorySelect.value;
                    const available = availabilitySelect.value;

                    const url = `{{ route('courts.index') }}?search=${search}&category_id=${category}&is_available=${available}`;

                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.text())
                        .then(html => {
                            tableContainer.innerHTML = html;
                        })
                        .catch(error => console.error('Error:', error));
                }

                // Event listeners
                searchInput.addEventListener('input', debounce(fetchCourts, 500));
                categorySelect.addEventListener('change', fetchCourts);
                availabilitySelect.addEventListener('change', fetchCourts);
            });
        </script>
    @endpush
    </div>
</x-admin-layout>