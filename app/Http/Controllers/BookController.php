<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $books = Book::with(['categories', 'series'])
            ->when($search, function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('author', 'like', "%$search%")
                  ->orWhere('isbn', 'like', "%$search%");
            })
            ->latest()
            ->paginate(10);

        $categories = Category::all();
        $series = \App\Models\BookSeries::all();

        $totalBuku = Book::count();
        $totalStok = (int) Book::sum('stock');

        return view('admin.buku.index', compact('books', 'categories', 'series', 'search', 'totalBuku', 'totalStok'));
    }

    public function create()
    {
        $categories = Category::all();
        $series = \App\Models\BookSeries::all();
        return view('admin.buku.create', compact('categories', 'series'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'isbn'         => 'nullable|string|max:50',
            'stock'        => 'required|integer|min:0',
            'author'       => 'nullable|string|max:255',
            'publisher'    => 'nullable|string|max:255',
            'pages'        => 'nullable|integer|min:1',
            'location'     => 'nullable|string|max:100',
            'sinopsis'     => 'nullable|string',
            'cover'        => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'book_series_id' => 'nullable|exists:book_series,id',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
        ]);

        // Handle cover upload
        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        $buku = Book::create([
            'title'     => $request->title,
            'isbn'      => $request->isbn,
            'author'    => $request->author ?? '-',
            'publisher' => $request->publisher,
            'pages'     => $request->pages,
            'stock'     => $request->stock,
            'cover'     => $coverPath,
            'book_series_id' => $request->book_series_id,
            'location'  => $request->location,
            'sinopsis'  => $request->sinopsis,
        ]);

        // Attach ke pivot table
        $buku->categories()->sync($request->category_ids);

        // Sync jumlah_buku di setiap kategori yang dipilih
        foreach ($request->category_ids as $catId) {
            $this->syncCategoryCount((int) $catId);
        }

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    public function update(Request $request, Book $buku)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'isbn'         => 'nullable|string|max:50',
            'stock'        => 'required|integer|min:0',
            'author'       => 'nullable|string|max:255',
            'publisher'    => 'nullable|string|max:255',
            'pages'        => 'nullable|integer|min:1',
            'location'     => 'nullable|string|max:100',
            'sinopsis'     => 'nullable|string',
            'cover'        => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'book_series_id' => 'nullable|exists:book_series,id',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        // Simpan kategori lama untuk sync hitungan
        $oldCategoryIds = $buku->categories()->pluck('categories.id')->toArray();

        $data = $request->only(['title', 'isbn', 'author', 'publisher', 'pages', 'stock', 'book_series_id', 'location', 'sinopsis']);

        if ($request->hasFile('cover')) {
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($data);

        // Sync kategori di pivot
        $newCategoryIds = $request->category_ids ?? [];
        $buku->categories()->sync($newCategoryIds);

        // Sync hitungan kategori lama & baru
        $allAffectedIds = array_unique(array_merge($oldCategoryIds, $newCategoryIds));
        foreach ($allAffectedIds as $catId) {
            $this->syncCategoryCount((int) $catId);
        }

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Book $buku)
    {
        $categoryIds = $buku->categories()->pluck('categories.id')->toArray();

        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }

        // Detach pivot sebelum delete
        $buku->categories()->detach();
        $buku->delete();

        // Update hitungan kategori
        foreach ($categoryIds as $catId) {
            $this->syncCategoryCount((int) $catId);
        }

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil dihapus!');
    }

    /**
     * Sinkronkan kolom jumlah_buku di kategori berdasarkan pivot.
     */
    private function syncCategoryCount(int $categoryId): void
    {
        $category = Category::find($categoryId);
        if ($category) {
            $category->update([
                'jumlah_buku' => $category->books()->count(),
            ]);
        }
    }
}
