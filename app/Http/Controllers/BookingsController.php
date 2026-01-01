<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Courts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Payments;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class BookingsController extends Controller
{
    // DETAIL BOOKING (untuk halaman showdetail.blade.php)
    public function show(string $id)
    {
        $booking = Bookings::with(['user', 'court'])->findOrFail($id);

        // tampilan detail di root: resources/views/showdetail.blade.php
        return view('showdetail', compact('booking'));
    }

    public function index(Request $request)
    {
        $query = Bookings::with(['user', 'court'])->latest();

        // Search: user name ATAU customer name (guest)
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%");
                })
                ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter tanggal
        if ($request->filled('date')) {
            $query->whereDate('booking_date', $request->date);
        }

        $bookings = $query->paginate(10)->withQueryString();

        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $courts = Courts::where('is_available', true)->get();

        return view('bookings.create', compact('courts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'court_id' => 'required|exists:courts,id',

            // Personal Info (WAJIB, editable)
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:30',

            'booking_date' => 'required|date',
            'start_time'   => 'required|date_format:H:i',
            'end_time'     => 'required|date_format:H:i|after:start_time',
            'total_price'  => 'required|numeric|min:0',
        ]);

        // Jika user login → isi user_id
        $validated['user_id'] = Auth::check() ? Auth::id() : null;

        // Default status
        $validated['status'] = 'Pending';

        Bookings::create($validated);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking berhasil dibuat.');
    }

    public function edit(string $id)
    {
        $booking = Bookings::findOrFail($id);
        $courts  = Courts::where('is_available', true)->get();

        return view('bookings.edit', compact('booking', 'courts'));
    }

    public function update(Request $request, string $id)
    {
        $booking = Bookings::findOrFail($id);

        $validated = $request->validate([
            'court_id' => 'exists:courts,id',

            // Personal Info tetap editable
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:30',

            'booking_date' => 'date',
            'start_time'   => 'date_format:H:i',
            'end_time'     => 'date_format:H:i|after:start_time',
            'total_price'  => 'numeric|min:0',
            'status'       => 'in:Pending,Confirmed,Cancelled,Completed',
        ]);

        $booking->update($validated);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $booking = Bookings::findOrFail($id);
        $booking->delete();

        return redirect()->route('bookings.index')
            ->with('success', 'Booking berhasil dihapus.');
    }

    public function myBookings()
    {
        $bookings = Bookings::with('court')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('mybookings', compact('bookings'));
    }

    public function processPayment(Request $request)
    {
        // 1. Validate Payment & Booking Data
        $validated = $request->validate([
            'payment_method' => 'required',
            'court_id'       => 'required|exists:courts,id',
            'booking_date'   => 'required|date',
            'start_time'     => 'required',
            'total_price'    => 'required|numeric',
            'customer_name'  => 'required|string',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'notes'          => 'nullable|string',
            'hours'          => 'required|integer|min:1',
        ]);

        // 2. Kalkulasi waktu berakhir
        $startTime = Carbon::createFromFormat('H:i', substr($validated['start_time'], 0, 5));
        $hours     = (int) $request->input('hours');
        $endTime   = $startTime->copy()->addHours($hours);

        $exists = Bookings::where('court_id', $validated['court_id'])
            ->whereDate('booking_date', $validated['booking_date'])
            ->whereIn('status', ['Pending', 'Confirmed', 'Completed'])
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime)
                  ->where('end_time', '>', $startTime);
            })
            ->exists();

        if ($exists) {
            return back()->with('error', 'Jam ini sudah dibooking');
        }

        // 3. Membuat Booking (Status Pending)
        $booking = Bookings::create([
            'user_id'        => Auth::id(),
            'court_id'       => $validated['court_id'],
            'booking_date'   => $validated['booking_date'],
            'start_time'     => $startTime->format('H:i'),
            'end_time'       => $endTime->format('H:i'),
            'total_price'    => $validated['total_price'] * 1.05, // pajak 5%
            'status'         => 'Pending',
            'customer_name'  => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'notes'          => $validated['notes'] ?? null,
        ]);

        // 4. Konfigurasi Midtrans
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized  = config('midtrans.isSanitized');
        Config::$is3ds        = config('midtrans.is3ds');

        // 5. Generate Order ID & Save to DB
        $orderId = 'BOOK-' . $booking->id . '-' . time();
        $booking->update(['midtrans_order_id' => $orderId]);

        // 6. Buat Transaksi Midtrans
        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $booking->total_price,
            ],
            'customer_details'    => [
                'first_name' => $validated['customer_name'],
                'email'      => $validated['customer_email'],
                'phone'      => $validated['customer_phone'],
            ],
            'item_details'        => [
                [
                    'id'       => 'COURT-' . $validated['court_id'],
                    'price'    => (int) $booking->total_price,
                    'quantity' => 1,
                    'name'     => 'Booking Lapangan Padel',
                ],
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return view('bookings.pay', compact('snapToken', 'booking'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat transaksi: ' . $e->getMessage());
        }
    }

    public function paymentCallback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed    = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            // Find booking by midtrans_order_id OR extract ID
            $booking = Bookings::where('midtrans_order_id', $request->order_id)->first();

            if (!$booking) {
                $orderIdParts = explode('-', $request->order_id);
                if (isset($orderIdParts[1])) {
                    $booking = Bookings::find($orderIdParts[1]);
                }
            }

            if ($booking) {
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    $booking->update(['status' => 'Confirmed']);

                    $exists = Payments::where('booking_id', $booking->id)->exists();
                    if (!$exists) {
                        Payments::create([
                            'booking_id'     => $booking->id,
                            'payment_method' => $request->payment_type,
                            'payment_status' => 'completed',
                            'payment_date'   => now(),
                            'amount'         => $request->gross_amount,
                        ]);
                    }
                } elseif (
                    $request->transaction_status == 'expire' ||
                    $request->transaction_status == 'cancel' ||
                    $request->transaction_status == 'deny'
                ) {
                    $booking->update(['status' => 'Cancelled']);
                }
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function success($id)
    {
        $booking = Bookings::with('court')->findOrFail($id);

        if ($booking->status == 'Pending' && $booking->midtrans_order_id) {
            $this->verifyMidtransStatus($booking);
        }

        return view('success', compact('booking'));
    }

    public function checkPaymentStatus($id)
    {
        $booking = Bookings::findOrFail($id);

        if (!$booking->midtrans_order_id) {
            return back()->with('error', 'System Error: No Midtrans Order ID found for this booking. Please contact admin.');
        }

        if ($booking->status == 'Pending') {
            try {
                $status = $this->verifyMidtransStatus($booking);

                if ($status) {
                    if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                        return back()->with('success', 'Payment success! Status updated to Confirmed.');
                    } elseif ($status->transaction_status == 'pending') {
                        return back()->with('info', 'Midtrans Verification: Payment is still PENDING. Please complete payment.');
                    } elseif (
                        $status->transaction_status == 'expire' ||
                        $status->transaction_status == 'cancel' ||
                        $status->transaction_status == 'deny'
                    ) {
                        return back()->with('warning', 'Payment failed or expired. Status: ' . $status->transaction_status);
                    } else {
                        return back()->with('info', 'Midtrans Status: ' . $status->transaction_status);
                    }
                }
            } catch (\Exception $e) {
                return back()->with('error', 'Check Failed: ' . $e->getMessage());
            }
        }

        return back()->with('info', 'Booking status is already ' . $booking->status);
    }

    private function verifyMidtransStatus($booking)
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized  = config('midtrans.isSanitized');
        Config::$is3ds        = config('midtrans.is3ds');

        try {
            $status = Transaction::status($booking->midtrans_order_id);

            if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                $booking->update(['status' => 'Confirmed']);

                $exists = Payments::where('booking_id', $booking->id)->exists();
                if (!$exists) {
                    Payments::create([
                        'booking_id'     => $booking->id,
                        'payment_method' => $status->payment_type ?? 'midtrans',
                        'payment_status' => 'completed',
                        'payment_date'   => now(),
                        'amount'         => $status->gross_amount,
                    ]);
                }
            } elseif (
                $status->transaction_status == 'expire' ||
                $status->transaction_status == 'cancel' ||
                $status->transaction_status == 'deny'
            ) {
                $booking->update(['status' => 'Cancelled']);
            }

            return $status;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
