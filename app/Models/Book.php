<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'isbn',
        'author',
        'publisher',
        'year',
        'pages',
        'stock',
        'cover',
        'location',
        'sinopsis',
        'book_series_id',
    ];

    /**
     * Many-to-many: sebuah buku bisa punya banyak kategori
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category');
    }

    /**
     * @deprecated gunakan categories() untuk multi-kategori
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function reviews()
    {
        return $this->hasMany(BookReview::class);
    }

    public function series()
    {
        return $this->belongsTo(BookSeries::class, 'book_series_id');
    }
}
