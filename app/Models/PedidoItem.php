<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'cardapio_id',
        'quantidade',
        'preco_unitario',
        'subtotal'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function cardapio()
    {
        return $this->belongsTo(Cardapio::class);
    }
}
