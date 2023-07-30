<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'produto_id',
        'usuario_id',
        'pontuacao',
        'mensagem'
    ];
    
    public function produto()
    {
        return $this->belongsTo('App\Models\Produto');
    }
    
    public function usuario()
    {
        return $this->belongsTo('App\Models\Cliente', 'usuario_id');
    }
}
