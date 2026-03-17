<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payment_id',
        'status',
        'amount',
        'event_time',
    ];

    protected $casts = [
        'event_time' => 'datetime',
    ];

    protected $table = 'payments';
}
