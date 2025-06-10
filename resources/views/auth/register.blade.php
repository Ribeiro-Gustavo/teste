@extends('layouts.menuLateral')

@section('content')
<div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="w-20 h-20 bg-primary-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl">
                <i class="fas fa-hamburger text-3xl text-white"></i>
            </div>
            <h2 class="text-4xl font-bold text-white mb-2">Crie sua Conta</h2>
            <p class="text-gray-400 text-lg">Junte-se à nossa comunidade</p>
        </div>

        <!-- Error Messages - MANTENDO A LÓGICA ORIGINAL EXATA -->
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

        <!-- Register Form - MANTENDO EXATAMENTE A MESMA FUNCIONALIDADE -->
        <div class="bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-700">
            <div class="p-8">
                <form action="{{ route('register') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Name Field - MANTENDO name, value e required originais -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-user mr-2 text-primary-500"></i>Nome
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                               placeholder="Nome">
                    </div>

                    <!-- Email Field - MANTENDO name, value e required originais -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-envelope mr-2 text-primary-500"></i>E-mail
                        </label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                               placeholder="E‑mail">
                    </div>

                    <!-- Password Field - MANTENDO name e required originais -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-lock mr-2 text-primary-500"></i>Senha
                        </label>
                        <input type="password"
                               name="password"
                               required
                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                               placeholder="Senha (mínimo 6)">
                    </div>

                    <!-- Password Confirmation Field - MANTENDO name e required originais -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-lock mr-2 text-primary-500"></i>Confirmar senha
                        </label>
                        <input type="password"
                               name="password_confirmation"
                               required
                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                               placeholder="Confirme a senha">
                    </div>

                    <!-- Terms -->
                    <!-- Submit Button - MANTENDO type="submit" original -->
                    <button type="submit"
                            class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                        <i class="fas fa-user-plus"></i>
                        <span>Registrar‑me</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

