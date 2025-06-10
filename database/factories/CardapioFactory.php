<?php

namespace Database\Factories;

use App\Models\Cardapio;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardapioFactory extends Factory
{
    protected $model = Cardapio::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->word,
            'quantidade' => $this->faker->numberBetween(1, 20),
            'validade' => $this->faker->date(),
            'preco' => $this->faker->randomFloat(2, 10, 50),
            'descricao' => $this->faker->sentence,
            'imagem' => 'cardapios/fake.jpg',
        ];
    }
}
