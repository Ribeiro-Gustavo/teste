<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Exibe o formulário de login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Processa o login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard'); // Redireciona à rota protegida
        }

        return back()->withErrors([
            'email' => 'As credenciais estão incorretas.',
        ])->onlyInput('email');
    }

    // Faz logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // exibe o form de registro
    public function showRegister()
    {
        return view('auth.register');
    }

    // processa o registro
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'              => ['required', 'string', 'min:6', 'confirmed'],
            'telefone'              => ['required', 'string', 'min:10', 'max:20', 'regex:/^[\d\s\(\)\-+\.]+$/'],
        ]);

        // adiciona telefone ao array de dados
        $data['telefone'] = $request->input('telefone');

        // cria e já criptografa a senha (cast 'hashed' no Model)
        $user = User::create($data);

        // loga automático
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
