<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Menampilkan data user dengan search dan filter.
     */
    public function index(Request $request)
    {
        // Pastikan hanya admin yang bisa akses
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $query = User::with('role');

        // Fitur Search (Nama atau Email)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Fitur Filter berdasarkan Role
        if ($request->filled('role')) {
            $role = $request->input('role');
            $query->whereHas('role', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        $roles = Role::all();

        if ($request->ajax()) {
            return view('admin.users.table', compact('users'))->render();
        }

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Menampilkan form tambah user baru.
     */
    public function create()
    {
        // Pastikan hanya admin yang bisa akses
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Menyimpan user baru ke database.
     */
    public function store(StoreUserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail user.
     */
    public function show(string $id)
    {
        // Pastikan hanya admin yang bisa akses
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::with('role')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Menampilkan form edit user.
     */
    public function edit(string $id)
    {
        // Pastikan hanya admin yang bisa akses
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Memperbarui data user.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ];

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Menghapus user.
     */
    public function destroy(string $id)
    {
        // Pastikan hanya admin yang bisa akses
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);

        // Cegah admin menghapus dirinya sendiri
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        // Pastikan hanya admin yang bisa akses
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $query = User::with('role');

        // Apply filters same as index for consistency
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $role = $request->input('role');
            $query->whereHas('role', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        $users = $query->latest()->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.users.pdf', compact('users'));

        return $pdf->download('laporan-user.pdf');
    }
}
