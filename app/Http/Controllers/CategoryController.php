<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $categories = Category::withCount('books')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        // For edit mode
        $editCategory = null;
        if ($request->has('edit')) {
            $editCategory = Category::find($request->get('edit'));
        }

        return view('admin.kategori.index', compact('categories', 'search', 'editCategory'));
    }

    /**
     * Store a newly created category.
     * Jumlah buku akan otomatis dihitung dari relasi books.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Kategori ini sudah ada.',
        ]);

        Category::create([
            'name'        => $request->name,
            'jumlah_buku' => 0, // diisi otomatis saat buku ditambahkan
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $kategori)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $kategori->id,
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Kategori ini sudah ada.',
        ]);

        $kategori->update([
            'name' => $request->name,
            // jumlah_buku tidak diubah manual, dihitung otomatis via BookController
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $kategori)
    {
        if ($kategori->books()->count() > 0) {
            return redirect()->route('admin.kategori.index')
                ->with('error', 'Tidak bisa menghapus kategori yang masih memiliki buku!');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
