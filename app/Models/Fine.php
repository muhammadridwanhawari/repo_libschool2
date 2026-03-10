<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $fillable = [
        'borrowing_id',
        'amount',
        'paid',
    ];

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }
}
