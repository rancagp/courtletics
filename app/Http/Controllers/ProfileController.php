<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Update the user's profile information
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return redirect()->route('profile.index')
            ->with('success', 'Profile berhasil diperbarui.');
    }

    /**
     * Update the user's password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Password berhasil diubah.');
    }
}
