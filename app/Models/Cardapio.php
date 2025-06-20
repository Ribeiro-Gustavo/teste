<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cardapio extends Model
{
use HasFactory;

    protected $fillable = ['nome', 'quantidade', 'preco', 'descricao', 'imagem', 'validade'];
}
