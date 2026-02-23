<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class SiswaKatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');

        // Search
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        // Sort
        $sort = $request->sort ?? 'title';
        $query->orderBy($sort);

        $books = $query->paginate(12);
        $categories = Category::all();

        // Selected book
        $selected = null;
        if ($request->selected) {
            $selected = Book::with('category')->find($request->selected);
        }

        return view('siswa.katalog', compact('books', 'categories', 'selected'));
    }
}