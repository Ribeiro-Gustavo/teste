<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Cardapio;

class CarrinhoTest extends TestCase
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

    public function test_usuario_pode_adicionar_item_ao_carrinho()
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/carrinho/adicionar', [
            'cardapio_id' => $this->produto->id,
            'quantidade' => 2
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Item adicionado ao carrinho']);
        $this->assertTrue(session()->has('carrinho.' . $this->produto->id));
    }

    public function test_usuario_nao_pode_adicionar_quantidade_maior_que_estoque()
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/carrinho/adicionar', [
            'cardapio_id' => $this->produto->id,
            'quantidade' => 15 // Mais que o estoque disponível
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['quantidade']);
    }

    public function test_usuario_pode_remover_item_do_carrinho()
    {
        $this->actingAs($this->user);

        // Primeiro adiciona um item
        $this->postJson('/carrinho/adicionar', [
            'cardapio_id' => $this->produto->id,
            'quantidade' => 1
        ]);

        // Depois remove
        $response = $this->deleteJson('/carrinho/remover/' . $this->produto->id);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Item removido do carrinho']);
        $this->assertFalse(session()->has('carrinho.' . $this->produto->id));
    }

    public function test_usuario_pode_limpar_carrinho()
    {
        $this->actingAs($this->user);

        // Adiciona alguns itens
        $this->postJson('/carrinho/adicionar', [
            'cardapio_id' => $this->produto->id,
            'quantidade' => 1
        ]);

        // Limpa o carrinho
        $response = $this->deleteJson('/carrinho/limpar');

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Carrinho limpo com sucesso']);
        $this->assertFalse(session()->has('carrinho'));
    }

    public function test_usuario_nao_pode_adicionar_item_inexistente()
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/carrinho/adicionar', [
            'cardapio_id' => 999, // ID inexistente
            'quantidade' => 1
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['cardapio_id']);
    }

    public function test_usuario_nao_pode_adicionar_quantidade_negativa()
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/carrinho/adicionar', [
            'cardapio_id' => $this->produto->id,
            'quantidade' => -1
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['quantidade']);
    }

    public function test_usuario_nao_pode_acessar_carrinho_sem_autenticacao()
    {
        $response = $this->post('/carrinho/adicionar', [
            'cardapio_id' => $this->produto->id,
            'quantidade' => 1
        ]);

        $response->assertRedirect('/login');
    }
}
