<?php

use Illuminate\Support\Facades\Route;
use App\Models\CourtCategories;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourtCategoriesController;
use App\Http\Controllers\CourtsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingsController; // Tambahkan ini untuk mengimpor BookingsController 
use App\Models\Bookings;   


Route::get('/', function () {
    $categories = CourtCategories::all();
    return view('home', compact('categories'));
});

// CSRF Token Refresh Route
Route::get('/refresh-csrf', function () {
    return response()->json(['token' => csrf_token()]);
});

// // Home page (sama dengan welcome)
// Route::get('/', function () {
//     return view('home');
// });

// About Page
Route::get('/about', function () {
    return view('about');
});

// Book Court - Court Selectio
Route::get('/book-court', function () {
    $category = null;
    $courts = [];
    $bookedSlots = collect();

    if (request()->has('category')) {
        $category = CourtCategories::with('courts')->find(request('category'));

        if ($category) {
            $courts = $category->courts;

            // ⬇️ AMBIL JAM YANG SUDAH DIBOOKING
            if (request()->filled('court_id') && request()->filled('date')) {
                $bookedSlots = Bookings::where('court_id', request('court_id'))
                    ->whereDate('booking_date', request('date'))
                    ->whereIn('status', ['Pending', 'Confirmed', 'Completed'])
                    ->get(['start_time', 'end_time']);
            }
        }
    }

    return view('courtdetail', compact('category', 'courts', 'bookedSlots'));
});

// Booking Detail Form
Route::get('/booking-detail', function () {
    return view('bookingcourt');
});

Route::get('/api/booked-slots', function () {
    request()->validate([
        'court_id' => 'required|exists:courts,id',
        'date' => 'required|date',
    ]);

    return \App\Models\Bookings::where('court_id', request('court_id'))
        ->whereDate('booking_date', request('date'))
        ->whereIn('status', ['Pending', 'Confirmed', 'Completed'])
        ->get(['start_time', 'end_time']);
});



// Payment Process
Route::post('/payment/process', [BookingsController::class, 'processPayment'])->name('payment.process');
Route::post('/payment/notification', [BookingsController::class, 'paymentCallback']); // Callback Midtrans

// Success Page
Route::get('/booking-success/{id}', [BookingsController::class, 'success'])->name('booking.success');
Route::post('/booking/{id}/check-status', [BookingsController::class, 'checkPaymentStatus'])->name('booking.check_status');

// Authentication Routes

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile Routes - Accessible by all authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
});

// Forgot Password (optional)
Route::get('/forgot-password', function () {
    return view('forgot-password');
});

// Admin Routes - Protected with auth middleware
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

    // User Management Routes (CRUD) - Only for Admin
    Route::get('/users/export-pdf', [UserController::class, 'exportPdf'])->name('users.exportPdf');
    Route::resource('users', UserController::class);
});

// Court Categories & Courts Management - Protected with auth and role:admin middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Court Categories Routes
    Route::get('/court-categories/export-pdf', [CourtCategoriesController::class, 'exportPdf'])->name('court-categories.exportPdf');
    Route::resource('court-categories', CourtCategoriesController::class);

    // Courts Routes
    Route::get('/courts/export-pdf', [CourtsController::class, 'exportPdf'])->name('courts.exportPdf');
    Route::resource('courts', CourtsController::class);
});


// my bookings user
Route::middleware(['auth'])->group(function () {
    Route::get('/my-bookings', [BookingsController::class, 'myBookings'])->name('my.bookings');
});

// show detail untuk di my bookings
Route::get('/my-bookings/{booking}', [BookingsController::class, 'show'])
    ->name('bookings.show');

    