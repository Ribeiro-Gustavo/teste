<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_pagina_registro_carrega_com_sucesso()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Crie sua Conta');
    }

    public function test_usuario_pode_se_registrar_com_dados_validos()
    {
        $dados = [
            'name' => 'Teste Usuario',
            'email' => 'teste@example.com',
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
            'telefone' => '(11) 98765-4321'
        ];

        $response = $this->post('/register', $dados);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', [
            'name' => 'Teste Usuario',
            'email' => 'teste@example.com',
            'telefone' => '(11) 98765-4321'
        ]);
        $this->assertAuthenticated();
    }

    public function test_usuario_nao_pode_se_registrar_com_email_duplicado()
    {
        User::factory()->create([
            'email' => 'teste@example.com'
        ]);

        $dados = [
            'name' => 'Outro Usuario',
            'email' => 'teste@example.com',
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
            'telefone' => '(11) 98765-4321'
        ];

        $response = $this->post('/register', $dados);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('users', [
            'name' => 'Outro Usuario'
        ]);
    }

    public function test_usuario_nao_pode_se_registrar_com_senha_curta()
    {
        $dados = [
            'name' => 'Teste Usuario',
            'email' => 'teste@example.com',
            'password' => '123',
            'password_confirmation' => '123',
            'telefone' => '(11) 98765-4321'
        ];

        $response = $this->post('/register', $dados);

        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', [
            'email' => 'teste@example.com'
        ]);
    }

    public function test_usuario_nao_pode_se_registrar_com_telefone_invalido()
    {
        $dados = [
            'name' => 'Teste Usuario',
            'email' => 'teste@example.com',
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
            'telefone' => '123' // Telefone muito curto
        ];

        $response = $this->post('/register', $dados);

        $response->assertSessionHasErrors('telefone');
        $this->assertDatabaseMissing('users', [
            'email' => 'teste@example.com'
        ]);
    }

    public function test_usuario_nao_pode_se_registrar_com_campos_vazios()
    {
        $response = $this->post('/register', []);

        $response->assertSessionHasErrors(['name', 'email', 'password', 'telefone']);
        $this->assertDatabaseCount('users', 0);
    }

    public function test_usuario_autenticado_redirecionado_da_pagina_registro()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/register');

        $response->assertRedirect('/dashboard');
    }
}
