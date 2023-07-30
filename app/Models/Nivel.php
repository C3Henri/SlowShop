<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Nivel extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nivel',
        'desconto'
    ];
    
    public function clientes()
    {
        return $this->hasMany('App\Models\Cliente');
    }
    
    public function descontos()
    {
        return $this->hasMany('App\Models\CategoriaDesconto');
    }
}
