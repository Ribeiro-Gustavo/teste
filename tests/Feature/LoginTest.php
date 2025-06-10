<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_pagina_login_carrega_com_sucesso()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Login');
    }

    public function test_usuario_pode_logar_com_credenciais_corretas()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard'); // Assumindo que /dashboard é a página após o login
        $this->assertAuthenticatedAs($user);
    }

    public function test_usuario_nao_pode_logar_com_credenciais_incorretas()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'senha-errada',
        ]);

        $response->assertSessionHasErrors('email'); // Ou o campo que você usa para erro de credenciais
        $this->assertGuest();
    }

    public function test_usuario_nao_pode_logar_com_campos_vazios()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
    }

    public function test_usuario_autenticado_redirecionado_da_pagina_login()
    {
        $user = User::factory()->create([
            'password' => 'password',
        ]);
        $this->actingAs($user);

        $response = $this->get('/login');

        $response->assertRedirect('/dashboard'); // Assumindo que /dashboard é para onde usuários logados são redirecionados
    }

    // Adicione mais testes, como: limite de tentativas de login, desautenticação, etc.
}
