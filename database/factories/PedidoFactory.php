<?php

namespace Database\Factories;

use App\Models\Pedido;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoFactory extends Factory
{
    protected $model = Pedido::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'nome_cliente' => $this->faker->name,
            'telefone_cliente' => $this->faker->phoneNumber,
            'endereco_entrega' => $this->faker->address,
            'horario_entrega' => $this->faker->dateTimeBetween('now', '+2 hours'),
            'observacoes' => $this->faker->optional()->sentence,
            'status' => $this->faker->randomElement(['pendente', 'em_preparo', 'entregue', 'cancelado']),
            'total' => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
