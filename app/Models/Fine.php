<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $fillable = [
        'borrowing_id',
        'amount',
        'paid',
        'payment_code',
        'payment_method',
        'payment_proof',
        'payment_status',
    ];

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }
}
