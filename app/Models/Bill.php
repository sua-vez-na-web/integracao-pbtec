<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder\Class_;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'customer_id',
        'due_date',
        'due_amount'
    ];

    protected $dates = [
        'due_date'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'bomcontrole_id');
    }

    public function notification()
    {
        return $this->hasOne(GeikoNotification::class);
    }
}
