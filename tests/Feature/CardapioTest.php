<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Cardapio;
use App\Models\User;

class CardapioTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function test_pagina_cardapios_index_carrega_com_sucesso()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/cardapios');
        $response->assertStatus(200);
        $response->assertSee('Cardápio'); // ajusta conforme o título da sua view
    }

    public function test_pagina_criacao_carrega_com_sucesso()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/cardapios/create');
        $response->assertStatus(200);
        $response->assertSee('Adicionar'); // ajusta conforme o conteúdo da view
    }

    public function test_cardapios_pode_ser_criado()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Storage::fake('public');

        $imagem = UploadedFile::fake()->image('hamburguer.jpg');

        $dados = [
            'nome' => 'X-Burguer',
            'quantidade' => 10,
            'validade' => now()->addDays(7)->format('Y-m-d'),
            'preco' => 19,
            'descricao' => 'Delicioso hambúrguer artesanal',
            'imagem' => $imagem,
        ];

        $response = $this->post('/cardapios', $dados);

        $response->assertRedirect('/cardapios');
        $this->assertDatabaseHas('cardapios', ['nome' => 'X-Burguer']);
        Storage::disk('public')->assertExists('cardapios/' . $imagem->hashName());
    }

    public function test_cardapios_pode_ser_editado()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Storage::fake('public');

        $cardapio = Cardapio::factory()->create([
            'imagem' => 'cardapios/old.jpg',
        ]);

        $novaImagem = UploadedFile::fake()->image('novo.jpg');

        $dados = [
            'nome' => 'X-Tudo',
            'quantidade' => 5,
            'validade' => now()->addDays(3)->format('Y-m-d'),
            'preco' => 25.00,
            'descricao' => 'Atualizado',
            'imagem' => $novaImagem,
        ];

        $response = $this->put("/cardapios/{$cardapio->id}", $dados);

        $response->assertRedirect('/cardapios');

        $updatedCardapio = Cardapio::find($cardapio->id);
        $this->assertEquals('X-Tudo', $updatedCardapio->nome);
        Storage::disk('public')->assertExists('cardapios/' . $novaImagem->hashName());
    }

    public function test_cardapios_pode_ser_removido()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

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

}
