@extends('layouts.menuLateral')

@section('content')
<div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('cardapios.index') }}" class="text-white hover:text-primary-200 transition-colors duration-200">
                    <i class="fas fa-arrow-left text-2xl"></i>
                </a>
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">Editar Produto</h1>
                    <p class="text-xl text-primary-100">Atualize as informações do produto</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-gray-800 rounded-xl shadow-2xl overflow-hidden border border-gray-700">
            <div class="p-8">
                <form action="{{ route('cardapios.update', $cardapio) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Nome -->
                    <div>
                        <label for="nome" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-hamburger mr-2 text-primary-500"></i>Nome do Produto
                        </label>
                        <input type="text"
                               id="nome"
                               name="nome"
                               value="{{ old('nome', $cardapio->nome) }}"
                               maxlength="25"
                               required
                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200">
                    </div>

                    <!-- Quantidade -->
                    <div>
                        <label for="quantidade" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-boxes mr-2 text-primary-500"></i>Quantidade em Estoque
                        </label>
                        <input type="number"
                               id="quantidade"
                               name="quantidade"
                               value="{{ old('quantidade', $cardapio->quantidade) }}"
                               min="0"
                               required
                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200">
                    </div>

                    <!-- Preço -->
                    <div>
                        <label for="preco" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-dollar-sign mr-2 text-primary-500"></i>Preço (R$)
                        </label>
                        <input type="number"
                               id="preco"
                               name="preco"
                               value="{{ old('preco', $cardapio->preco) }}"
                               step="0.01"
                               min="0"
                               required
                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200">
                    </div>

                    <!-- Descrição -->
                    <div>
                        <label for="descricao" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-align-left mr-2 text-primary-500"></i>Descrição
                        </label>
                        <textarea id="descricao"
                                  name="descricao"
                                  maxlength="125"
                                  rows="4"
                                  required
                                  class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200 resize-none">{{ old('descricao', $cardapio->descricao) }}</textarea>
                        <p class="text-gray-400 text-sm mt-1">Máximo 125 caracteres</p>
                    </div>

                    <!-- Imagem Atual -->
                    @if($cardapio->imagem)
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-image mr-2 text-primary-500"></i>Imagem Atual
                            </label>
                            <div class="bg-gray-700 rounded-lg p-4">
                                <img src="{{ asset('storage/' . $cardapio->imagem) }}"
                                     alt="{{ $cardapio->nome }}"
                                     class="w-32 h-32 object-cover rounded-lg mx-auto">
                            </div>
                        </div>
                    @endif

                    <!-- Nova Imagem -->
                    <div>
                        <label for="imagem" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-upload mr-2 text-primary-500"></i>{{ $cardapio->imagem ? 'Nova Imagem (opcional)' : 'Imagem do Produto' }}
                        </label>
                        <input type="file"
                               id="imagem"
                               name="imagem"
                               accept="image/*"
                               {{ $cardapio->imagem ? '' : 'required' }}
                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary-600 file:text-white file:cursor-pointer hover:file:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200">
                        <p class="text-gray-400 text-sm mt-1">Formatos aceitos: JPG, PNG, GIF</p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex space-x-4 pt-6">
                        <a href="{{ route('cardapios.index') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 text-center">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </a>
                        <button type="submit" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200">
                            <i class="fas fa-save mr-2"></i>Atualizar Produto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
