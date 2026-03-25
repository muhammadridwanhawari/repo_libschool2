<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $series = \App\Models\BookSeries::withCount('books')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })
            ->latest()
            ->paginate(10);

        $editSeries = null;
        if ($request->has('edit')) {
            $editSeries = \App\Models\BookSeries::find($request->input('edit'));
        }

        return view('admin.series.index', compact('series', 'search', 'editSeries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:book_series',
            'description' => 'nullable|string',
        ]);

        \App\Models\BookSeries::create($request->all());

        return redirect()->route('admin.series.index')->with('success', 'Series berhasil ditambahkan!');
    }

    public function update(Request $request, \App\Models\BookSeries $series)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:book_series,name,' . $series->id,
            'description' => 'nullable|string',
        ]);

        $series->update($request->all());

        return redirect()->route('admin.series.index')->with('success', 'Series berhasil diperbarui!');
    }

    public function destroy(\App\Models\BookSeries $series)
    {
        if ($series->books()->count() > 0) {
            return redirect()->route('admin.series.index')->with('error', 'Series tidak bisa dihapus karena masih memiliki buku!');
        }

        $series->delete();

        return redirect()->route('admin.series.index')->with('success', 'Series berhasil dihapus!');
    }
}
