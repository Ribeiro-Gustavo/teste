<?php

namespace Database\Factories;

use App\Models\Pagamento;
use App\Models\Pedido;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagamentoFactory extends Factory
{
    protected $model = Pagamento::class;

    public function definition()
    {
        return [
            'pedido_id' => Pedido::factory(),
            'tipo_pagamento' => 'cartao',
            'status' => 'aprovado',
            'valor' => $this->faker->randomFloat(2, 10, 200),
            'transaction_id' => $this->faker->uuid(),
            'qr_code' => null,
            'expires_at' => null,
        ];
    }
}
