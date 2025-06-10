@extends('layouts.menuLateral')

@section('content')
<div class="min-h-screen" style="background-color:#111111;">
    <!-- Header -->
    <div class="py-12" style="background: linear-gradient(90deg, #f97316 0%, #c2410c 100%);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('cardapios.index') }}" class="text-white hover:text-primary-200 transition-colors duration-200">
                    <i class="fas fa-arrow-left text-2xl"></i>
                </a>
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">Adicionar Produto</h1>
                    <p class="text-xl text-primary-100">Crie um novo item para o cardápio</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
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
        </div>
    @endif

    <!-- Form -->
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="rounded-xl shadow-2xl overflow-hidden" style="background-color:#181818; border:1px solid #222222;">
            <div class="p-8">
                <form action="{{ route('cardapios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Nome -->
                    <div>
                        <label for="nome" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-hamburger mr-2 text-primary-500"></i>Nome do Produto
                        </label>
                        <input type="text"
                               id="nome"
                               name="nome"
                               value="{{ old('nome') }}"
                               maxlength="25"
                               required
                               class="w-full px-4 py-3 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                               style="background-color:#222222; border:1px solid #333333;"
                               placeholder="Ex: Hambúrguer Artesanal">
                    </div>

                    <!-- Quantidade -->
                    <div>
                        <label for="quantidade" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-boxes mr-2 text-primary-500"></i>Quantidade em Estoque
                        </label>
                        <input type="number"
                               id="quantidade"
                               name="quantidade"
                               value="{{ old('quantidade') }}"
                               min="0"
                               required
                               class="w-full px-4 py-3 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                               style="background-color:#222222; border:1px solid #333333;"
                               placeholder="0">
                    </div>

                    <!-- Preço -->
                    <div>
                        <label for="preco" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-dollar-sign mr-2 text-primary-500"></i>Preço (R$)
                        </label>
                        <input type="number"
                               id="preco"
                               name="preco"
                               value="{{ old('preco') }}"
                               step="0.01"
                               min="0"
                               required
                               class="w-full px-4 py-3 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                               style="background-color:#222222; border:1px solid #333333;"
                               placeholder="0.00">
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
                                  class="w-full px-4 py-3 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200 resize-none"
                                  style="background-color:#222222; border:1px solid #333333;"
                                  placeholder="Descreva os ingredientes e características do produto...">{{ old('descricao') }}</textarea>
                        <p class="text-gray-400 text-sm mt-1">Máximo 125 caracteres</p>
                    </div>

                    <!-- Imagem -->
                    <div>
                        <label for="imagem" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-image mr-2 text-primary-500"></i>Imagem do Produto
                        </label>
                        <div class="relative">
                            <input type="file"
                                   id="imagem"
                                   name="imagem"
                                   accept="image/jpeg,image/png,image/webp"
                                   required
                                   class="w-full px-4 py-3 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-white file:cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                                   style="background-color:#222222; border:1px solid #333333; file-background-color:#f97316; hover:file-background-color:#ea580c;"
                                   placeholder="Escolha uma imagem">
                        </div>
                        <p class="text-gray-400 text-sm mt-1">Formatos aceitos: JPG, JPEG, PNG, WEBP. Não são permitidos GIFs ou vídeos.</p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex space-x-4 pt-6">
                        <a href="{{ route('cardapios.index') }}" class="flex-1 font-semibold py-3 px-6 rounded-lg transition-colors duration-200 text-center"
                           style="background-color:#222222; hover:background-color:#333333; color:#ffffff;">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </a>
                        <button type="submit" class="flex-1 font-semibold py-3 px-6 rounded-lg transition-colors duration-200"
                                style="background-color:#f97316; hover:background-color:#ea580c; color:#ffffff;">
                            <i class="fas fa-save mr-2"></i>Salvar Produto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
