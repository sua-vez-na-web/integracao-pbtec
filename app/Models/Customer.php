<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'cnpj',
        'razao_social',
        'nome_fantasia',
        'bomcontrole_id',
        'geiko_id'
    ];
}
