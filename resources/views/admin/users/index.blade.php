<x-admin-layout>
    <x-slot name="title">Manajemen User</x-slot>
    <x-slot name="header">Manajemen User</x-slot>

    <div class="bg-white rounded-lg shadow-md">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <!-- Search Form -->
                <form method="GET" action="{{ route('admin.users.index') }}" id="searchForm" class="flex-1">
                    <div class="flex gap-3">
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                            placeholder="Cari nama atau email..."
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">

                        <select name="role" id="roleSelect"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Semua Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit"
                            class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>

                        @if (request('search') || request('role'))
                            <a href="{{ route('admin.users.index') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Buttons -->
                <div class="flex gap-2">
                    <!-- Export PDF Button -->
                    <a href="{{ route('admin.users.exportPdf', request()->all()) }}" target="_blank"
                        class="flex items-center gap-2 px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="font-medium">Export PDF</span>
                    </a>

                    <!-- Add User Button -->
                    <a href="{{ route('admin.users.create') }}"
                        class="flex items-center gap-2 px-6 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:shadow-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span class="font-medium">Tambah User</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto" id="user-table-container">
            @include('admin.users.table')
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.querySelector('input[name="search"]');
                const roleSelect = document.querySelector('select[name="role"]');
                const tableContainer = document.getElementById('user-table-container');

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

                function fetchUsers() {
                    const search = searchInput.value;
                    const role = roleSelect.value;
                    const url = `{{ route('admin.users.index') }}?search=${search}&role=${role}`;

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
                searchInput.addEventListener('input', debounce(fetchUsers, 500));
                roleSelect.addEventListener('change', fetchUsers);
            });
        </script>
    @endpush
</x-admin-layout>