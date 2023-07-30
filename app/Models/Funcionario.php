<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Funcionario extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'nome', 
        'email', 
        'password', 
        'cargo', 
        'criado_por', 
        'data_de_criacao',
        'data_de_atualizacao'
    ];

    protected $hidden = [
        'password',
        'created_at', 
        'updated_at'
    ];
    
    public function criadoPor()
    {
        return $this->belongsTo('App\Models\Funcionario', 'criado_por');
    }
    
    public function funcionariosCriados()
    {
        return $this->hasMany('App\Models\Funcionario', 'criado_por');
    }
}
