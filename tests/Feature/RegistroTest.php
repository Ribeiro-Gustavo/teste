<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class RegistroTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_pode_se_registrar()
    {
        $userData = [
            'name' => 'Teste Usuario',
            'email' => 'teste@exemplo.com',
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
            'telefone' => '11999999999'
        ];

        $response = $this->post('/register', $userData);

        $response->assertStatus(302)
            ->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', [
            'name' => 'Teste Usuario',
            'email' => 'teste@exemplo.com'
        ]);
    }

    public function test_registro_falha_com_senhas_diferentes()
    {
        $userData = [
            'name' => 'Teste Usuario',
            'email' => 'teste@exemplo.com',
            'password' => 'senha123',
            'password_confirmation' => 'senha456',
            'telefone' => '11999999999'
        ];

        $response = $this->post('/register', $userData);

        $response->assertStatus(302)
            ->assertSessionHasErrors('password');
    }

    public function test_registro_falha_com_email_ja_existente()
    {
        // Primeiro cria um usuário
        User::create([
            'name' => 'Usuario Existente',
            'email' => 'teste@exemplo.com',
            'password' => Hash::make('senha123'),
            'telefone' => '11999999999'
        ]);

        // Tenta criar outro com o mesmo email
        $userData = [
            'name' => 'Novo Usuario',
            'email' => 'teste@exemplo.com',
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
            'telefone' => '11999999999'
        ];

        $response = $this->post('/register', $userData);

        $response->assertStatus(302)
            ->assertSessionHasErrors('email');
    }

    public function test_registro_falha_com_campos_obrigatorios_faltando()
    {
        $userData = [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
            'telefone' => ''
        ];

        $response = $this->post('/register', $userData);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['name', 'email', 'password', 'telefone']);
    }
}
