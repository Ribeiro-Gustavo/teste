<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cardapio;
use App\Models\Pedido;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PedidoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->cardapio = Cardapio::factory()->create([
            'preco' => 25.00
        ]);
    }

    public function test_usuario_pode_criar_pedido()
    {
        $dadosPedido = [
            'itens' => [
                [
                    'cardapio_id' => $this->cardapio->id,
                    'quantidade' => 2
                ]
            ],
            'endereco_entrega' => 'Rua Teste, 123',
            'observacoes' => 'Sem cebola'
        ];

        $response = $this->actingAs($this->user)
            ->post('/pedidos', $dadosPedido);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Pedido criado com sucesso']);

        $this->assertDatabaseHas('pedidos', [
            'user_id' => $this->user->id,
            'endereco_entrega' => 'Rua Teste, 123',
            'observacoes' => 'Sem cebola',
            'status' => 'pendente'
        ]);
    }

    public function test_usuario_pode_ver_seus_pedidos()
    {
        // Cria alguns pedidos
        Pedido::factory()->count(3)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user)
            ->get('/pedidos');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_usuario_pode_ver_detalhes_do_pedido()
    {
        $pedido = Pedido::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user)
            ->get('/pedidos/' . $pedido->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $pedido->id
                ]
            ]);
    }

    public function test_usuario_pode_cancelar_pedido()
    {
        $pedido = Pedido::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'pendente'
        ]);

        $response = $this->actingAs($this->user)
            ->put('/pedidos/' . $pedido->id . '/cancelar');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Pedido cancelado com sucesso']);

        $this->assertDatabaseHas('pedidos', [
            'id' => $pedido->id,
            'status' => 'cancelado'
        ]);
    }

    public function test_usuario_nao_pode_cancelar_pedido_em_preparo()
    {
        $pedido = Pedido::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'em_preparo'
        ]);

        $response = $this->actingAs($this->user)
            ->put('/pedidos/' . $pedido->id . '/cancelar');

        $response->assertStatus(403)
            ->assertJson(['message' => 'Não é possível cancelar um pedido em preparo']);
    }

    public function test_usuario_nao_pode_ver_pedido_de_outro_usuario()
    {
        $outroUsuario = User::factory()->create();
        $pedido = Pedido::factory()->create([
            'user_id' => $outroUsuario->id
        ]);

        $response = $this->actingAs($this->user)
            ->get('/pedidos/' . $pedido->id);

        $response->assertStatus(403);
    }

    public function test_criacao_pedido_falha_sem_itens()
    {
        $dadosPedido = [
            'itens' => [],
            'endereco_entrega' => 'Rua Teste, 123'
        ];

        $response = $this->actingAs($this->user)
            ->post('/pedidos', $dadosPedido);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['itens']);
    }
}
