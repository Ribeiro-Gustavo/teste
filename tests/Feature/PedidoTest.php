<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Pedido;
use App\Models\Cardapio;

class PedidoTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $produto;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->produto = Cardapio::factory()->create([
            'nome' => 'X-Burguer',
            'preco' => 19.90,
            'quantidade' => 10
        ]);
    }

    public function test_usuario_pode_criar_pedido()
    {
        $this->actingAs($this->user);

        // Adiciona item ao carrinho na sessão do teste
        $this->withSession([
            'carrinho' => [
                $this->produto->id => [
                    'nome' => $this->produto->nome,
                    'quantidade' => 2,
                    'validade' => $this->produto->validade,
                    'preco' => $this->produto->preco,
                ]
            ]
        ]);

        $response = $this->postJson('/pedidos/finalizar', [
            'nome_cliente' => 'Cliente Teste',
            'telefone_cliente' => '11999999999',
            'endereco_entrega' => 'Rua Teste, 123',
            'horario_entrega' => now()->addHour()->format('Y-m-d H:i:s'),
            'observacoes' => 'Sem cebola'
        ]);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Pedido criado com sucesso']);

        $this->assertDatabaseHas('pedidos', [
            'user_id' => $this->user->id,
            'nome_cliente' => 'Cliente Teste',
            'telefone_cliente' => '11999999999',
            'endereco_entrega' => 'Rua Teste, 123',
            'observacoes' => 'Sem cebola',
            'status' => 'pendente'
        ]);
    }

    public function test_usuario_pode_ver_seus_pedidos()
    {
        $this->actingAs($this->user);

        // Cria alguns pedidos
        Pedido::factory()->count(3)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->getJson('/pedidos');

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [
                '*' => ['id', 'status', 'total', 'created_at']
            ]]);
    }

    public function test_usuario_pode_ver_detalhes_do_pedido()
    {
        $this->actingAs($this->user);

        $pedido = Pedido::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->getJson('/pedidos/' . $pedido->id);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [
                'id', 'status', 'total', 'created_at', 'items'
            ]]);
    }

    public function test_usuario_pode_cancelar_pedido()
    {
        $this->actingAs($this->user);

        $pedido = Pedido::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'pendente'
        ]);

        $response = $this->putJson('/pedidos/' . $pedido->id . '/cancelar');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Pedido cancelado com sucesso']);

        $this->assertDatabaseHas('pedidos', [
            'id' => $pedido->id,
            'status' => 'cancelado'
        ]);
    }

    public function test_usuario_nao_pode_cancelar_pedido_em_preparo()
    {
        $this->actingAs($this->user);

        $pedido = Pedido::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'em_preparo'
        ]);

        $response = $this->putJson('/pedidos/' . $pedido->id . '/cancelar');

        $response->assertStatus(403)
            ->assertJson(['message' => 'Não é possível cancelar um pedido em preparo']);
    }

    public function test_usuario_nao_pode_ver_pedido_de_outro_usuario()
    {
        $this->actingAs($this->user);

        $outroUsuario = User::factory()->create();
        $pedido = Pedido::factory()->create([
            'user_id' => $outroUsuario->id
        ]);

        $response = $this->getJson('/pedidos/' . $pedido->id);

        $response->assertStatus(403);
    }

    public function test_criacao_pedido_falha_sem_itens()
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/pedidos/finalizar', [
            'nome_cliente' => 'Cliente Teste',
            'telefone_cliente' => '11999999999',
            'endereco_entrega' => 'Rua Teste, 123',
            'horario_entrega' => now()->addHour()->format('Y-m-d H:i:s'),
            'observacoes' => 'Sem cebola'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['itens']);
    }
}
