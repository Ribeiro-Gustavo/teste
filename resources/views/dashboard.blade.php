{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.menuLateral')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, #111111 0%, #181818 50%, #111111 100%);">
    <!-- Header -->
    <div class="py-12" style="background: linear-gradient(90deg, #f97316 0%, #c2410c 100%);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-white mb-4">
                    Bem-vindo, <span class="text-primary-200">{{ auth()->user()->name }}</span>!
                </h1>
                <p class="text-xl text-primary-100">Gerencie sua hamburgueria com facilidade</p>
            </div>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <div class="rounded-xl p-6 border" style="background-color:#181818; border:1px solid #222222;">
                <div class="flex items-center">
                    <div class="bg-primary-600 p-3 rounded-lg">
                        <i class="fas fa-hamburger text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm" style="color:#bdbdbd;">Total de Produtos</p>
                        <p class="text-2xl font-bold text-white">{{ \App\Models\Cardapio::count() }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl p-6 border" style="background-color:#181818; border:1px solid #222222;">
                <div class="flex items-center">
                    <div class="bg-green-600 p-3 rounded-lg">
                        <i class="fas fa-shopping-cart text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm" style="color:#bdbdbd;">Itens no Carrinho</p>
                        <p class="text-2xl font-bold text-white">{{ array_sum(array_column(session('carrinho', []), 'quantidade')) }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl p-6 border" style="background-color:#181818; border:1px solid #222222;">
                <div class="flex items-center">
                    <div class="bg-gray-900 p-3 rounded-lg">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm" style="color:#bdbdbd;">Usuários</p>
                        <p class="text-2xl font-bold text-white">{{ \App\Models\User::count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Actions Card -->
            <div class="rounded-xl p-8 border" style="background-color:#181818; border:1px solid #222222;">
                <h2 class="text-2xl font-bold text-white mb-6">
                    <i class="fas fa-bolt text-primary-500 mr-2"></i>Ações Rápidas
                </h2>

                <div class="space-y-4">
                    <a href="{{ route('cardapios.index') }}" class="flex items-center p-4 rounded-lg hover:bg-gray-600 transition-colors duration-200 group" style="background-color:#222222; color:#bdbdbd;">
                        <div class="bg-primary-600 p-3 rounded-lg group-hover:bg-primary-700 transition-colors duration-200">
                            <i class="fas fa-utensils text-white"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-white font-semibold">Gerenciar Cardápio</h3>
                            <p class="text-sm" style="color:#bdbdbd;">Visualizar e editar produtos</p>
                        </div>
                        <i class="fas fa-chevron-right ml-auto" style="color:#757575;"></i>
                    </a>

                    <a href="{{ route('cardapios.create') }}" class="flex items-center p-4 rounded-lg hover:bg-gray-600 transition-colors duration-200 group" style="background-color:#222222; color:#bdbdbd;">
                        <div class="bg-green-600 p-3 rounded-lg group-hover:bg-green-700 transition-colors duration-200">
                            <i class="fas fa-plus text-white"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-white font-semibold">Adicionar Produto</h3>
                            <p class="text-sm" style="color:#bdbdbd;">Criar novo item no cardápio</p>
                        </div>
                        <i class="fas fa-chevron-right ml-auto" style="color:#757575;"></i>
                    </a>

                    <a href="{{ route('sobre') }}" class="flex items-center p-4 rounded-lg hover:bg-gray-600 transition-colors duration-200 group" style="background-color:#222222; color:#bdbdbd;">
                        <div class="bg-gray-900 p-3 rounded-lg group-hover:bg-gray-800 transition-colors duration-200">
                            <i class="fas fa-info-circle text-white"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-white font-semibold">Sobre a Hamburgueria</h3>
                            <p class="text-sm" style="color:#bdbdbd;">Nossa história e valores</p>
                        </div>
                        <i class="fas fa-chevron-right ml-auto" style="color:#757575;"></i>
                    </a>
                </div>
            </div>

            <!-- User Info Card -->
            <div class="rounded-xl p-8 border" style="background-color:#181818; border:1px solid #222222;">
                <h2 class="text-2xl font-bold text-white mb-6">
                    <i class="fas fa-user text-primary-500 mr-2"></i>Informações da Conta
                </h2>

                <div class="space-y-4">
                    <div class="flex items-center p-4 rounded-lg" style="background-color:#222222; color:#bdbdbd;">
                        <div class="bg-primary-600 p-3 rounded-lg">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm" style="color:#bdbdbd;">Nome</p>
                            <p class="text-white font-semibold">{{ auth()->user()->name }}</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 rounded-lg" style="background-color:#222222; color:#bdbdbd;">
                        <div class="bg-gray-900 p-3 rounded-lg">
                            <i class="fas fa-envelope text-white"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm" style="color:#bdbdbd;">Email</p>
                            <p class="text-white font-semibold">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 rounded-lg" style="background-color:#222222; color:#bdbdbd;">
                        <div class="bg-green-600 p-3 rounded-lg">
                            <i class="fas fa-calendar text-white"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm" style="color:#bdbdbd;">Membro desde</p>
                            <p class="text-white font-semibold">{{ auth()->user()->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
