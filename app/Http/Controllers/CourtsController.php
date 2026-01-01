<?php

namespace App\Http\Controllers;

use App\Models\Courts;
use App\Models\CourtCategories;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CourtsController extends Controller
{
    public function index(Request $request)
    {
        $query = Courts::with('courtCategory');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('court_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('court_category_id', $request->category_id);
        }

        if ($request->filled('is_available')) {
            $query->where('is_available', $request->is_available);
        }

        $courts = $query->paginate(10)->withQueryString();
        $categories = CourtCategories::all();

        if ($request->ajax()) {
            return view('admin.courts.table', compact('courts', 'categories'))->render();
        }

        return view('admin.courts.index', compact('courts', 'categories'));
    }

    public function create()
    {
        $categories = CourtCategories::all();
        return view('admin.courts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'court_category_id' => 'required|exists:court_categories,id',
            'court_name'        => 'required|string|max:255|unique:courts,court_name',
            'location'          => 'required|string|max:255',
            'price_per_hour'    => 'required|numeric|min:0',
            'description'       => 'nullable|string|max:2000',
        ]);

        $validated['is_available'] = $request->has('is_available');

        Courts::create($validated);

        return redirect()->route('courts.index')
            ->with('success', 'Lapangan berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $court = Courts::findOrFail($id);
        $categories = CourtCategories::all();

        return view('admin.courts.edit', compact('court', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $court = Courts::findOrFail($id);

        $validated = $request->validate([
            'court_category_id' => 'required|exists:court_categories,id',
            'court_name'        => 'required|string|max:255|unique:courts,court_name,' . $court->id,
            'location'          => 'required|string|max:255',
            'price_per_hour'    => 'required|numeric|min:0',
            'description'       => 'nullable|string|max:2000',
        ]);

        $validated['is_available'] = $request->has('is_available');

        $court->update($validated);

        return redirect()->route('courts.index')
            ->with('success', 'Lapangan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $court = Courts::findOrFail($id);

        if ($court->bookings()->whereIn('status', ['Pending', 'Confirmed'])->exists()) {
            return redirect()->route('courts.index')
                ->with('error', 'Lapangan tidak dapat dihapus karena masih memiliki booking aktif.');
        }

        $court->delete();

        return redirect()->route('courts.index')
            ->with('success', 'Lapangan berhasil dihapus.');
    }

    /**
     * ===============================
     * EXPORT PDF LAPANGAN (FIX FINAL)
     * ===============================
     */
    public function exportPdf()
    {
        $courts = Courts::with('courtCategory')->get();

        $pdf = Pdf::loadView('admin.courts.pdf', compact('courts'));

        return $pdf->download('laporan-data-lapangan.pdf');
    }
}
