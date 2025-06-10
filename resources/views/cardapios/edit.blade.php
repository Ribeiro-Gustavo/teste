@extends('layouts.menuLateral')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, #111111 0%, #181818 50%, #111111 100%);">
    <!-- Header -->
    <div class="py-12" style="background: linear-gradient(90deg, #f97316 0%, #c2410c 100%);">
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
        <div class="bg-gray-800 rounded-xl shadow-2xl overflow-hidden border border-gray-700">
            <div class="p-8">
                <form action="{{ route('cardapios.update', $cardapio) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="form-produto">
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
                               maxlength="20"
                               required
                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                               placeholder="Nome do produto (máx 20 caracteres)">
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
                               max="1000"
                               required
                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                               placeholder="Máximo 1000 unidades">
                        <p class="text-gray-400 text-sm mt-1">Quantidade máxima: 1000</p>
                    </div>

                    <!-- Preço -->
                    <div>
                        <label for="preco" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-dollar-sign mr-2 text-primary-500"></i>Preço (R$)
                        </label>
                        <input type="text"
                               id="preco"
                               name="preco"
                               value="{{ old('preco', number_format($cardapio->preco, 2, ',', '.')) }}"
                               required
                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                               placeholder="R$ 0,00">
                    </div>

                    <!-- Descrição -->
                    <div>
                        <label for="descricao" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-align-left mr-2 text-primary-500"></i>Descrição
                        </label>
                        <textarea id="descricao"
                                  name="descricao"
                                  maxlength="100"
                                  rows="4"
                                  required
                                  class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200 resize-none"
                                  placeholder="Descrição do produto (máx 100 caracteres)">{{ old('descricao', $cardapio->descricao) }}</textarea>
                        <p class="text-gray-400 text-sm mt-1">Máximo 100 caracteres</p>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
$(document).ready(function(){
    $('#preco').mask('000.000.000.000.000,00', {reverse: true});

    $('#quantidade').on('input', function() {
        let val = parseInt($(this).val());
        if(val > 1000){
            $(this).val(1000);
        } else if(val < 0 || isNaN(val)) {
            $(this).val(0);
        }
    });

    $('#nome').on('input', function() {
        if($(this).val().length > 20){
            $(this).val($(this).val().substr(0, 20));
        }
    });


});
</script>

@endsection
