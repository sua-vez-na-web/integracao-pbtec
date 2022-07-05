<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeikoNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'message',
        'include_at',
        'removed_at',
        'customer_id',
        'type'
    ];

    protected $dates = [
        'include_at',
        'removed_at'
    ];
}
