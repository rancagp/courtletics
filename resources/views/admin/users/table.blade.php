<table class="w-full">
    <thead class="bg-gray-50 border-b border-gray-200">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                No
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Nama
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Email
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Role
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Tanggal Dibuat
            </th>
            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Aksi
            </th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse ($users as $index => $user)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ $users->firstItem() + $index }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-600 to-indigo-600 flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    {{ $user->email }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span
                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $user->role->name === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                        {{ ucfirst($user->role->name) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    {{ $user->created_at->format('d M Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}"
                            class="text-indigo-600 hover:text-indigo-900 transition" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>

                        @if ($user->id !== Auth::id())
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 transition" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        @else
                            <span class="text-gray-400" title="Tidak bisa menghapus akun sendiri">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="text-lg font-medium">Tidak ada data user ditemukan</p>
                    @if (request('search') || request('role'))
                        <p class="text-sm mt-2">Coba ubah kriteria pencarian Anda</p>
                    @endif
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Pagination -->
@if ($users->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $users->links() }}
    </div>
@endif