<?php

namespace Database\Factories;

use App\Models\PedidoItem;
use App\Models\Pedido;
use App\Models\Cardapio;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoItemFactory extends Factory
{
    protected $model = PedidoItem::class;

    public function definition()
    {
        return [
            'pedido_id' => Pedido::factory(),
            'cardapio_id' => Cardapio::factory(),
            'quantidade' => $this->faker->numberBetween(1, 5),
            'preco_unitario' => $this->faker->randomFloat(2, 5, 50),
        ];
    }
}
