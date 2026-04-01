<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string|null $isbn
 * @property string|null $author
 * @property string|null $publisher
 * @property string|null $year
 * @property int|null $pages
 * @property int $stock
 * @property string|null $cover
 * @property string|null $location
 * @property string|null $sinopsis
 * @property int|null $book_series_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
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
