<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'produto_id',
        'preco_original',
        'preco_pago',
        'pago',
        'data_de_compra',
        'bairro',
        'numero',
        'complemento',
        'cidade',
        'estado',
        'cep',
    ];

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente');
    }

    public function produto()
    {
        return $this->belongsTo('App\Models\Produto');
    }
}
