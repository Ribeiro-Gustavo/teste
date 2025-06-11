<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Exibe o formulário de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Processa o login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required' => 'O email é obrigatório',
            'email.email' => 'Por favor, insira um email válido',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres',
        ]);

        // Verifica se o usuário existe
        $user = User::where('email', $credentials['email'])->first();
        if (!$user) {
            return back()->withErrors([
                'email' => 'Credenciais inválidas.',
            ])->onlyInput('email');
        }

        // Tenta fazer login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ])->onlyInput('email');
    }

    // Faz logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // exibe o form de registro
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // processa o registro
    public function register(Request $request)
    {
        // Validação inicial dos dados
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:150', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/'],
            'email' => ['required', 'email:rfc,dns', 'max:150', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                'min:6',
                'max:255',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ],
            'telefone' => ['required', 'string', 'min:14', 'max:15', 'regex:/^\(\d{2}\)\s\d{5}-\d{4}$/'],
        ], [
            'name.regex' => 'O nome deve conter apenas letras e espaços',
            'name.min' => 'O nome deve ter pelo menos 3 caracteres',
            'name.max' => 'O nome não pode ter mais de 150 caracteres',
            'email.email' => 'Por favor, insira um email válido',
            'email.unique' => 'Este email já está cadastrado',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres',
            'password.regex' => 'A senha deve conter pelo menos uma letra maiúscula, uma minúscula e um número',
            'password.confirmed' => 'A confirmação da senha não corresponde',
            'telefone.regex' => 'O telefone deve estar no formato (00) 00000-0000',
        ]);

        // Verifica se o email já existe (dupla verificação)
        if (User::where('email', $data['email'])->exists()) {
            return back()->withErrors([
                'email' => 'Este email já está cadastrado.',
            ])->withInput();
        }

        // Verifica se as senhas correspondem (dupla verificação)
        if ($request->input('password') !== $request->input('password_confirmation')) {
            return back()->withErrors([
                'password' => 'As senhas não correspondem.',
            ])->withInput();
        }

        // Remove caracteres não numéricos do telefone antes de salvar
        $data['telefone'] = preg_replace('/\D/', '', $request->input('telefone'));

        // Cria o usuário
        $user = User::create($data);

        // Loga automaticamente
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
