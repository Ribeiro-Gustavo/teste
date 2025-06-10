<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Cardapio;
use App\Models\User;

class CardapioTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_pagina_cardapios_index_carrega_com_sucesso()
    {
        $this->actingAs($this->user);
        $response = $this->get('/cardapios');
        $response->assertStatus(200);
        $response->assertSee('Cardápio');
    }

    public function test_pagina_criacao_carrega_com_sucesso()
    {
        $this->actingAs($this->user);
        $response = $this->get('/cardapios/create');
        $response->assertStatus(200);
        $response->assertSee('Adicionar Produto');
    }

    public function test_cardapios_pode_ser_criado()
    {
        $this->actingAs($this->user);
        Storage::fake('public');

        $imagem = UploadedFile::fake()->image('hamburguer.jpg');

        $dados = [
            'nome' => 'X-Burguer',
            'quantidade' => 10,
            'validade' => now()->addDays(7)->format('Y-m-d'),
            'preco' => 19.90,
            'descricao' => 'Delicioso hambúrguer artesanal',
            'imagem' => $imagem,
        ];

        $response = $this->post('/cardapios', $dados);

        $response->assertRedirect('/cardapios');
        $this->assertDatabaseHas('cardapios', [
            'nome' => 'X-Burguer',
            'quantidade' => 10,
            'preco' => 19.90,
            'descricao' => 'Delicioso hambúrguer artesanal'
        ]);
        Storage::disk('public')->assertExists('cardapios/' . $imagem->hashName());
    }

    public function test_cardapios_nao_pode_ser_criado_com_dados_invalidos()
    {
        $this->actingAs($this->user);

        $dados = [
            'nome' => '', // Nome vazio
            'quantidade' => -1, // Quantidade negativa
            'preco' => 'abc', // Preço inválido
            'descricao' => '', // Descrição vazia
        ];

        $response = $this->post('/cardapios', $dados);

        $response->assertSessionHasErrors(['nome', 'quantidade', 'preco', 'descricao']);
        $this->assertDatabaseMissing('cardapios', ['nome' => '']);
    }

    public function test_cardapios_pode_ser_editado()
    {
        $this->actingAs($this->user);
        Storage::fake('public');

        $cardapio = Cardapio::factory()->create([
            'nome' => 'X-Burguer Original',
            'preco' => 19.90,
        ]);

        $novaImagem = UploadedFile::fake()->image('novo.jpg');

        $dados = [
            'nome' => 'X-Tudo',
            'quantidade' => 5,
            'validade' => now()->addDays(3)->format('Y-m-d'),
            'preco' => 25.90,
            'descricao' => 'Hambúrguer atualizado',
            'imagem' => $novaImagem,
        ];

        $response = $this->put("/cardapios/{$cardapio->id}", $dados);

        $response->assertRedirect('/cardapios');
        $this->assertDatabaseHas('cardapios', [
            'id' => $cardapio->id,
            'nome' => 'X-Tudo',
            'quantidade' => 5,
            'preco' => 25.90,
            'descricao' => 'Hambúrguer atualizado'
        ]);
        Storage::disk('public')->assertExists('cardapios/' . $novaImagem->hashName());
    }

    public function test_cardapios_pode_ser_removido()
    {
        $this->actingAs($this->user);
        Storage::fake('public');

        $imagem = UploadedFile::fake()->image('delete.jpg')->store('cardapios', 'public');

        $cardapio = Cardapio::factory()->create([
            'imagem' => $imagem,
        ]);

        $response = $this->delete("/cardapios/{$cardapio->id}");

        $response->assertRedirect('/cardapios');
        $this->assertDatabaseMissing('cardapios', ['id' => $cardapio->id]);
        Storage::disk('public')->assertMissing($imagem);
    }

    public function test_usuario_nao_autenticado_nao_pode_acessar_cardapio()
    {
        $response = $this->get('/cardapios');
        $response->assertRedirect('/login');
    }

    public function test_usuario_nao_autenticado_nao_pode_criar_cardapio()
    {
        $response = $this->get('/cardapios/create');
        $response->assertRedirect('/login');
    }

    public function test_usuario_nao_autenticado_nao_pode_editar_cardapio()
    {
        $cardapio = Cardapio::factory()->create();
        $response = $this->get("/cardapios/{$cardapio->id}/edit");
        $response->assertRedirect('/login');
    }
}
