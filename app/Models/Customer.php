<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'cnpj',
        'rgie',
        'razao_social',
        'nome_fantasia',
        'bomcontrole_id',
        'geiko_id',
        'cidade',
        'uf',
        'logradouro',
        'cep',
        'tipo_cadastro',
        'bairro',
        'numero',
        'complemento',
        'contato',
        'telefone',
        'email',
        'status'
    ];

    public function scopeFilterCnpj($query, $cnpj)
    {
        return $query->where('cnpj', '=', $cnpj);
    }
}
