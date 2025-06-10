<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'tipo_pagamento',
        'status',
        'valor',
        'transaction_id',
        'qr_code',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
