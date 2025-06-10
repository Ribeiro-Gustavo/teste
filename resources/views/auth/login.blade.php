@extends('layouts.menuLateral')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(135deg, #111111 0%, #181818 50%, #111111 100%);">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="w-20 h-20 bg-primary-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl">
                <i class="fas fa-hamburger text-3xl text-white"></i>
            </div>
            <h2 class="text-4xl font-bold text-white mb-2">Bem-vindo de volta!</h2>
            <p class="text-gray-400 text-lg">Entre na sua conta para continuar</p>
        </div>

        <!-- Error Messages - MANTENDO A LÓGICA ORIGINAL -->
        @if($errors->any())
            <div class="bg-red-600 border border-red-500 text-white px-4 py-3 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            </div>
        @endif

        <!-- Login Form - MANTENDO EXATAMENTE A MESMA FUNCIONALIDADE -->
        <div class="bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-700">
            <div class="p-8">
                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf

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
                               placeholder="E-mail">
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
                               placeholder="Senha">
                    </div>

                    <!-- Submit Button - MANTENDO type="submit" original -->
                    <button type="submit"
                            class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Entrar</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Register Link - MANTENDO route original -->
        <div class="text-center">
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                <p class="text-gray-400 mb-4">Não tem conta? <a href="{{ route('register') }}" class="text-primary-400 hover:text-primary-300 transition-colors duration-200">Crie uma agora</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
