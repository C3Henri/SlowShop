<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaDesconto extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nivel_id',
        'categoria_id',
        'desconto'
    ];
    
    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria');
    }
    
    public function nivel()
    {
        return $this->belongsTo('App\Models\Nivel');
    }
}
