<?php

namespace App\Http\Controllers;

use App\Models\CourtCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

class CourtCategoriesController extends Controller
{
    /**
     * Menampilkan daftar kategori lapangan dengan fitur search
     */
    public function index(Request $request)
    {
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $query = CourtCategories::query();

        // Fitur Search (Nama Kategori)
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('category_name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        $categories = $query->latest()->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('admin.court_categories.table', compact('categories'))->render();
        }

        return view('admin.court_categories.index', compact('categories'));
    }


    public function create()
    {
        // Menampilkan form tambah
        return view('admin.court_categories.create');
    }


    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'category_name' => 'required|string|max:255|unique:court_categories,category_name',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $validated['image'] = $path;
        }

        CourtCategories::create($validated);

        return redirect()->route('court-categories.index')
            ->with('success', 'Kategori lapangan berhasil ditambahkan.');
    }


    public function show(string $id)
    {
        $category = CourtCategories::findOrFail($id);
        return view('admin.court_categories.show', compact('category'));
    }


    public function edit(string $id)
    {
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $category = CourtCategories::findOrFail($id);
        // Menampilkan form edit
        return view('admin.court_categories.edit', compact('category'));
    }

    /**
     * Update kategori
     */
    public function update(Request $request, string $id)
    {
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $category = CourtCategories::findOrFail($id);

        $validated = $request->validate([
            'category_name' => 'required|string|max:255|unique:court_categories,category_name,' . $id,
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $path = $request->file('image')->store('categories', 'public');
            $validated['image'] = $path;
        }

        $category->update($validated);

        return redirect()->route('court-categories.index')
            ->with('success', 'Kategori lapangan berhasil diperbarui.');
    }

    /**
     * Hapus kategori
     */
    public function destroy(string $id)
    {
        $category = CourtCategories::findOrFail($id);

        // Cek apakah kategori masih digunakan oleh courts
        if ($category->courts()->count() > 0) {
            return redirect()->route('court-categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh ' . $category->courts()->count() . ' lapangan.');
        }

        // Delete image if exists
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('court-categories.index')
            ->with('success', 'Kategori lapangan berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $query = CourtCategories::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('category_name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        $categories = $query->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.court_categories.pdf', compact('categories'));

        return $pdf->download('laporan-kategori-lapangan.pdf');
    }
}
