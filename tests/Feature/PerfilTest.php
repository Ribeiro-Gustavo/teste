<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PerfilTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'name' => 'Usuario Teste',
            'email' => 'teste@exemplo.com',
            'telefone' => '11999999999'
        ]);
    }

    public function test_usuario_pode_atualizar_dados_pessoais()
    {
        $novosDados = [
            'name' => 'Novo Nome',
            'telefone' => '11988888888',
            'endereco' => 'Rua Teste, 123'
        ];

        $response = $this->actingAs($this->user)
            ->put('/perfil/atualizar', $novosDados);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Perfil atualizado com sucesso']);

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'Novo Nome',
            'telefone' => '11988888888'
        ]);
    }

    public function test_usuario_pode_alterar_senha()
    {
        $dadosSenha = [
            'senha_atual' => 'senha123',
            'nova_senha' => 'novasenha123',
            'nova_senha_confirmation' => 'novasenha123'
        ];

        $response = $this->actingAs($this->user)
            ->put('/perfil/senha', $dadosSenha);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Senha alterada com sucesso']);
    }

    public function test_alteracao_senha_falha_com_senha_atual_incorreta()
    {
        $dadosSenha = [
            'senha_atual' => 'senha_errada',
            'nova_senha' => 'novasenha123',
            'nova_senha_confirmation' => 'novasenha123'
        ];

        $response = $this->actingAs($this->user)
            ->put('/perfil/senha', $dadosSenha);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['senha_atual']);
    }

    public function test_usuario_pode_upload_foto_perfil()
    {
        Storage::fake('public');

        $foto = UploadedFile::fake()->image('foto.jpg');

        $response = $this->actingAs($this->user)
            ->post('/perfil/foto', [
                'foto' => $foto
            ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Foto atualizada com sucesso']);

        Storage::disk('public')->assertExists('perfil/' . $foto->hashName());
    }

    public function test_upload_foto_falha_com_arquivo_invalido()
    {
        Storage::fake('public');

        $arquivo = UploadedFile::fake()->create('documento.pdf', 100);

        $response = $this->actingAs($this->user)
            ->post('/perfil/foto', [
                'foto' => $arquivo
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['foto']);
    }

    public function test_usuario_nao_autenticado_nao_pode_acessar_perfil()
    {
        $response = $this->get('/perfil');
        $response->assertRedirect('/login');
    }
}
