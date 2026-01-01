<?php

namespace App\Http\Controllers;

use App\Models\Courts;
use App\Models\CourtCategories;
use App\Models\User;
use App\Models\Bookings;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Admin Dashboard with statistics
     */
    public function adminDashboard()
    {
        // Pastikan hanya admin yang bisa akses
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Get statistics
        $totalUsers = User::count();
        $totalCourts = Courts::count();
        $totalBookings = Bookings::count();
        $totalRevenue = Payments::where('payment_status', 'completed')->sum('amount');

        // Recent users (last 5)
        $recentUsers = User::with('role')->latest()->take(5)->get();

        // Recent bookings (last 5)
        $recentBookings = Bookings::with(['user', 'court'])->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCourts',
            'totalBookings',
            'totalRevenue',
            'recentUsers',
            'recentBookings'
        ));
    }

    public function index(Request $request)
    {
        $query = Courts::with('courtCategory');

        // Fitur Search (Nama Lapangan atau Lokasi)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('court_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Fitur Filter: Berdasarkan Kategori
        if ($request->filled('category_id')) {
            $query->where('court_category_id', $request->input('category_id'));
        }

        // Fitur Filter: Berdasarkan Status Ketersediaan (Available / Not)
        if ($request->filled('is_available')) {
            $query->where('is_available', $request->input('is_available'));
        }

        $courts = $query->paginate(10)->withQueryString();
        
        // Kirim data categories untuk opsi filter di view
        $categories = CourtCategories::all();

        return view('dashboard.courts.index', compact('courts', 'categories'));
    }

}