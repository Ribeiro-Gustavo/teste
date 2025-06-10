<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cardapio;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarrinhoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->cardapio = Cardapio::factory()->create();
    }

    public function test_usuario_pode_adicionar_item_ao_carrinho()
    {
        $response = $this->actingAs($this->user)
            ->post('/carrinho/adicionar', [
                'cardapio_id' => $this->cardapio->id,
                'quantidade' => 2
            ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Item adicionado ao carrinho']);
    }

    public function test_usuario_pode_remover_item_do_carrinho()
    {
        // Primeiro adiciona um item
        $this->actingAs($this->user)
            ->post('/carrinho/adicionar', [
                'cardapio_id' => $this->cardapio->id,
                'quantidade' => 1
            ]);

        // Depois remove
        $response = $this->actingAs($this->user)
            ->delete('/carrinho/remover/' . $this->cardapio->id);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Item removido do carrinho']);
    }

    public function test_usuario_pode_atualizar_quantidade_no_carrinho()
    {
        // Primeiro adiciona um item
        $this->actingAs($this->user)
            ->post('/carrinho/adicionar', [
                'cardapio_id' => $this->cardapio->id,
                'quantidade' => 1
            ]);

        // Depois atualiza a quantidade
        $response = $this->actingAs($this->user)
            ->put('/carrinho/atualizar', [
                'cardapio_id' => $this->cardapio->id,
                'quantidade' => 3
            ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Quantidade atualizada']);
    }

    public function test_usuario_pode_limpar_carrinho()
    {
        // Primeiro adiciona alguns itens
        $this->actingAs($this->user)
            ->post('/carrinho/adicionar', [
                'cardapio_id' => $this->cardapio->id,
                'quantidade' => 1
            ]);

        // Depois limpa o carrinho
        $response = $this->actingAs($this->user)
            ->delete('/carrinho/limpar');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Carrinho limpo com sucesso']);
    }

    public function test_usuario_nao_autenticado_nao_pode_acessar_carrinho()
    {
        $response = $this->get('/carrinho');
        $response->assertRedirect('/login');
    }
}
