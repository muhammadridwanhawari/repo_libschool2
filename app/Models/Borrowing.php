<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Book;
use App\Models\User;
use App\Models\Fine;

class Borrowing extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'booking_code',
        'borrow_date',
        'deadline',
        'return_date',
        'status',
    ];

    /**
     * Generate kode booking unik format: BK-YYYYMMDD-XXXX
     */
    public static function generateBookingCode(): string
    {
        do {
            $code = 'BK-' . now()->format('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        } while (self::where('booking_code', $code)->exists());

        return $code;
    }

    protected $casts = [
        'borrow_date' => 'date',
        'deadline' => 'date',
        'return_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function fine(): HasOne
    {
        return $this->hasOne(Fine::class);
    }

    /**
     * Determine status: if still 'dipinjam' but past deadline, consider 'terlambat'
     */
    public function getStatusDisplayAttribute(): string
    {
        if ($this->status === 'dikembalikan') return 'dikembalikan';
        if ($this->status === 'booking') return 'booking';
        if ($this->deadline && now()->gt($this->deadline)) return 'terlambat';
        return 'dipinjam';
    }
}
