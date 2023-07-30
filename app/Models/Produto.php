<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nome',
        'categoria_id',
        'classificacao',
        'quantidade_total',
        'quantidade_comprada',
        'descricao',
        'preco',
        'imagem',
    ];

    protected $appends = [
        'quantidade_reviews',
        'pontuacao_media',
        'quantidade_disponivel'
    ];
    
    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria');
    }
    
    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function pedidos()
    {
        return $this->hasMany('App\Models\Pedido');
    }

    public function getQuantidadeReviewsAttribute()
    {
        return $this->reviews()->count();
    }

    public function getPontuacaoMediaAttribute()
    {
        return $this->reviews()->avg('pontuacao');
    }

    public function getQuantidadeDisponivelAttribute()
    {
        return $this->quantidade_total - $this->quantidade_comprada;
    }
}
