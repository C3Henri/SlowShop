<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Cliente extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'nome', 
        'email', 
        'password', 
        'verificado', 
        'token_de_verificacao', 
        'token_de_recuperacao', 
        'data_de_expiracao_do_token_de_recuperacao', 
        'nivel_id',
        'data_de_criacao',
        'data_de_atualizacao'
    ];

    protected $hidden = [
        'password',
        'token_de_verificacao',
        'token_de_recuperacao',
        'data_de_expiracao_do_token_de_recuperacao',
        'created_at', 
        'updated_at'
    ];

    protected $appends = [
        'total_de_pedidos',
        'total_review',
        'nome_abreviado'
    ];
    
    public function nivel()
    {
        return $this->belongsTo('App\Models\Nivel');
    }
    
    public function reviews()
    {
        return $this->hasMany('App\Models\Review', 'usuario_id');
    }

    public function pedidos()
    {
        return $this->hasMany('App\Models\Pedido', 'cliente_id');
    }

    public function getTotalDePedidosAttribute()
    {
        return $this->pedidos()->count();
    }

    public function getTotalReviewAttribute()
    {
        return $this->reviews()->count();
    }

    public function getNomeAbreviadoAttribute()
    {
        $nome = explode(' ', $this->nome);
        $nomeAbreviado = $nome[0];
        if(count($nome) > 1) {
            $nomeAbreviado .= ' ' . $nome[count($nome) - 1];
        }
        return $nomeAbreviado;
    }
}