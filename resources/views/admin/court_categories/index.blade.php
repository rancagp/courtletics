<x-admin-layout>
    <x-slot name="title">Manajemen Kategori Lapangan</x-slot>
    <x-slot name="header">Manajemen Kategori Lapangan</x-slot>

    <div class="bg-white rounded-lg shadow-md">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <!-- Search Form -->
                <form method="GET" action="{{ route('court-categories.index') }}" id="searchForm" class="flex-1">
                    <div class="relative max-w-md">
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Cari kategori..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </form>

                <!-- Buttons -->
                <div class="flex gap-2">
                    <!-- Export PDF Button -->
                    <a href="{{ route('court-categories.exportPdf', request()->all()) }}" target="_blank"
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        PDF
                    </a>

                    <!-- Add Button -->
                    <a href="{{ route('court-categories.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Kategori
                    </a>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto" id="tableContainer">
            @include('admin.court_categories.table')
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const tableContainer = document.getElementById('tableContainer');

                // Debounce function untuk menghindari terlalu banyak request
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

                // Fungsi untuk fetch data kategori
                function fetchCategories() {
                    const searchValue = searchInput.value;
                    const url = new URL('{{ route('court-categories.index') }}');
                    
                    if (searchValue) {
                        url.searchParams.append('search', searchValue);
                    }

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

                // Event listener untuk live search
                searchInput.addEventListener('input', debounce(fetchCategories, 500));
            });
        </script>
    @endpush
</x-admin-layout>