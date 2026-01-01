<x-admin-layout>
    <x-slot name="title">Dashboard Admin</x-slot>
    <x-slot name="header">Dashboard Admin</x-slot>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Users</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Courts -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Lapangan</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalCourts }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Bookings -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Booking</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalBookings }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Pendapatan</p>
                    <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Users -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">User Terbaru</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse ($recentUsers as $user)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-600 to-indigo-600 flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <span
                                class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $user->role->name === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($user->role->name) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">Belum ada user</p>
                    @endforelse
                </div>
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.users.index') }}"
                        class="text-purple-600 hover:text-purple-700 font-medium text-sm flex items-center justify-center">
                        Lihat Semua User
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Booking Terbaru</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse ($recentBookings as $booking)
                        <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg transition">
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-900">
                                    {{ $booking->customer_name ?? $booking->user->name ?? 'Guest' }}
                                </p>
                                
                                <p class="text-xs text-gray-500 mb-1">
                                    {{ $booking->court->court_name ?? 'Lapangan Dihapus' }}
                                </p>
                                
                                <p class="text-xs text-gray-400 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                                    
                                    <span class="mx-1">•</span>
                                    
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                </p>
                            </div>

                            @php
                                // Cek nama kolom (status atau booking_status)
                                $rawStatus = $booking->status ?? $booking->booking_status ?? 'Pending';
                                
                                $statusStyles = [
                                    'Pending'   => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                    'Confirmed' => 'bg-green-100 text-green-800 border border-green-200',
                                    'Completed' => 'bg-blue-100 text-blue-800 border border-blue-200',
                                    'Cancelled' => 'bg-red-100 text-red-800 border border-red-200',
                                ];
                                
                                $statusLabels = [
                                    'Pending'   => 'Menunggu',
                                    'Confirmed' => 'Lunas',
                                    'Completed' => 'Selesai',
                                    'Cancelled' => 'Batal',
                                ];

                                $style = $statusStyles[$rawStatus] ?? 'bg-gray-100 text-gray-600';
                                $label = $statusLabels[$rawStatus] ?? $rawStatus;
                            @endphp

                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $style }}">
                                {{ $label }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500 text-sm">Belum ada booking terbaru</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.users.create') }}"
                class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-purple-600 hover:shadow-md transition">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-gray-800">Tambah User</p>
                    <p class="text-xs text-gray-500">Buat user baru</p>
                </div>
            </a>

            <a href="{{ route('admin.users.index') }}"
                class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-blue-600 hover:shadow-md transition">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-gray-800">Kelola User</p>
                    <p class="text-xs text-gray-500">Lihat & edit user</p>
                </div>
            </a>

            <a href="/"
                class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-green-600 hover:shadow-md transition">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-gray-800">Website</p>
                    <p class="text-xs text-gray-500">Ke halaman utama</p>
                </div>
            </a>
        </div>
    </div>
</x-admin-layout>
