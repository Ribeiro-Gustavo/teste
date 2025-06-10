@extends('layouts.menuLateral')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        /* Para campos preenchidos automaticamente */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0px 1000px #222222 inset !important; /* Cor de fundo dos inputs */
            -webkit-text-fill-color: #ffffff !important; /* Cor do texto */
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background-color:#111111;">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <img src="{{ asset('images/gusta_logo.png') }}" alt="Gusta's Burguer Logo" class="h-24 w-auto mx-auto mb-6 object-contain">
            <h2 class="text-4xl font-bold text-white mb-2">Crie sua Conta</h2>
            <p class="text-gray-400 text-lg">Junte-se à nossa comunidade</p>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="bg-red-600 border border-red-500 text-white px-4 py-3 rounded-lg shadow-lg">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle mr-2 mt-0.5"></i>
                    <div>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Register Form -->
        <div class="rounded-2xl shadow-2xl overflow-hidden" style="background-color:#181818; border:1px solid #222222;">
            <div class="p-8">
                <form action="{{ route('register') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-user mr-2 text-primary-500"></i>Nome
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               class="w-full px-4 py-3 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                               style="background-color:#222222; border:1px solid #333333;"
                               placeholder="Nome">
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-envelope mr-2 text-primary-500"></i>E-mail
                        </label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               class="w-full px-4 py-3 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                               style="background-color:#222222; border:1px solid #333333;"
                               placeholder="E‑mail">
                    </div>

                    <!-- Telefone Field -->
                    <div>
                        <label for="telefone" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-phone mr-2 text-primary-500"></i>Telefone
                        </label>
                        <input type="text"
                               name="telefone"
                               value="{{ old('telefone') }}"
                               required
                               class="w-full px-4 py-3 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                               style="background-color:#222222; border:1px solid #333333;"
                               placeholder="(00) 00000-0000">
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-lock mr-2 text-primary-500"></i>Senha
                        </label>
                        <input type="password"
                               name="password"
                               required
                               class="w-full px-4 py-3 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                               style="background-color:#222222; border:1px solid #333333;"
                               placeholder="Senha (mínimo 6)">
                    </div>

                    <!-- Password Confirmation Field -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-lock mr-2 text-primary-500"></i>Confirmar senha
                        </label>
                        <input type="password"
                               name="password_confirmation"
                               required
                               class="w-full px-4 py-3 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                               style="background-color:#222222; border:1px solid #333333;"
                               placeholder="Confirme a senha">
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col space-y-3">
                        <button type="submit"
                                class="w-full text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2"
                                style="background-color:#f97316; hover:background-color:#ea580c;">
                            <i class="fas fa-user-plus"></i>
                            <span>Registrar‑me</span>
                        </button>

                        <a href="{{ route('login') }}"
                           class="w-full text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center space-x-2"
                           style="background-color:#222222; hover:background-color:#333333;">
                            <i class="fas fa-arrow-left"></i>
                            <span>Voltar ao Login</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

