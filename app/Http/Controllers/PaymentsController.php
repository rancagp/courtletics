<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use App\Models\Bookings;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function index(Request $request)
    {
        $query = Payments::with('booking.user')->latest();

        // Fitur Search: Cari berdasarkan nama user pembayar (via relasi booking)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('booking.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Fitur Filter: Status Pembayaran (Paid/Unpaid)
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->input('payment_status'));
        }

        // Fitur Filter: Metode Pembayaran
        if ($request->filled('payment_method')) {
            $query->where('payment_method', 'like', "%{$request->input('payment_method')}%");
        }

        $payments = $query->paginate(10)->withQueryString();

        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        // Hanya booking yang belum lunas (opsional filter)
        $bookings = Bookings::all(); 
        return view('payments.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string',
            'payment_date' => 'nullable|date',
            'amount' => 'required|numeric|min:0',
        ]);

        if (empty($validated['payment_date']) && $validated['payment_status'] === 'Paid') {
            $validated['payment_date'] = now();
        }

        Payments::create($validated);

        return redirect()->route('payments.index')
                         ->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function show(string $id)
    {
        $payment = Payments::with('booking')->findOrFail($id);
        return view('payments.show', compact('payment'));
    }

    public function edit(string $id)
    {
        $payment = Payments::findOrFail($id);
        $bookings = Bookings::all();
        return view('payments.edit', compact('payment', 'bookings'));
    }

    public function update(Request $request, string $id)
    {
        $payment = Payments::findOrFail($id);

        $validated = $request->validate([
            'payment_method' => 'string',
            'payment_status' => 'string',
            'payment_date' => 'nullable|date',
            'amount' => 'numeric|min:0',
        ]);

        $payment->update($validated);

        return redirect()->route('payments.index')
                         ->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $payment = Payments::findOrFail($id);
        $payment->delete();

        return redirect()->route('payments.index')
                         ->with('success', 'Data pembayaran berhasil dihapus.');
    }
}