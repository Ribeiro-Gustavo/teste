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
                        <input type="text"
                               id="preco"
                               name="preco"
                               value="{{ old('preco') }}"
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
                                   accept="image/jpeg,image/jpg,image/png,image/webp"
                                   required
                                   class="w-full px-4 py-3 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-white file:cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                                   style="background-color:#222222; border:1px solid #333333; file-background-color:#f97316; hover:file-background-color:#ea580c;"
                                   placeholder="Escolha uma imagem">
                        </div>
                        <p class="text-gray-400 text-sm mt-1">Formatos aceitos: JPG, JPEG, PNG, WEBP. Tamanho máximo: 4MB</p>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
$(document).ready(function(){
    // Máscara para preço: aceita números com vírgula e ponto como decimal
    const precoInput = document.getElementById('preco');

    precoInput.addEventListener('input', function(e) {
        let value = this.value;

        // Remove tudo que não é número ou vírgula ou ponto
        value = value.replace(/[^\d,\.]/g, '');

        // Substitui ponto por vírgula (para padrão brasileiro)
        value = value.replace(/\./g, ',');

        // Só deixa uma vírgula
        const parts = value.split(',');
        if(parts.length > 2){
            value = parts[0] + ',' + parts[1];
        }

        // Limita casas decimais para 2
        if(parts[1] && parts[1].length > 2){
            parts[1] = parts[1].slice(0, 2);
            value = parts[0] + ',' + parts[1];
        }

        // Verifica se o valor é maior que 1000
        const numericValue = parseFloat(value.replace(',', '.'));
        if(numericValue > 1000) {
            value = '1000,00';
            alert('O preço máximo permitido é R$ 1.000,00');
        }

        this.value = value;
    });

    // Validação e máscara para quantidade
    $('#quantidade').on('input', function() {
        let val = parseInt($(this).val());
        if(val > 1000){
            $(this).val(1000);
            alert('Quantidade máxima permitida é 1000');
        } else if(val < 0 || isNaN(val)) {
            $(this).val(0);
        }
    });

    // Validação para nome
    $('#nome').on('input', function() {
        let val = $(this).val();
        // Remove caracteres especiais exceto hífen
        val = val.replace(/[^a-zA-ZÀ-ÿ\s-]/g, '');
        if(val.length > 25){
            val = val.substr(0, 25);
        }
        $(this).val(val);
    });

    // Validação para descrição
    $('#descricao').on('input', function() {
        let val = $(this).val();
        if(val.length > 125){
            val = val.substr(0, 125);
            alert('Descrição atingiu o limite máximo de 125 caracteres');
        }
        $(this).val(val);
    });

    // Validação de imagem
    $('#imagem').on('change', function() {
        const file = this.files[0];
        if(!file) return;

        // Verifica o tipo do arquivo
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if(!validTypes.includes(file.type)){
            alert('Formato inválido! Use apenas JPG, JPEG, PNG ou WEBP.');
            this.value = '';
            return;
        }

        // Verifica o tamanho do arquivo (4MB)
        if(file.size > 4 * 1024 * 1024){
            alert('A imagem deve ter no máximo 4MB');
            this.value = '';
            return;
        }

        // Verifica a extensão do arquivo
        const fileName = file.name.toLowerCase();
        const validExtensions = ['.jpg', '.jpeg', '.png', '.webp'];
        const hasValidExtension = validExtensions.some(ext => fileName.endsWith(ext));
        
        if(!hasValidExtension) {
            alert('Formato inválido! Use apenas JPG, JPEG, PNG ou WEBP.');
            this.value = '';
            return;
        }
    });

    // Previne submissão do formulário se houver erros
    $('form').on('submit', function(e) {
        let hasError = false;
        
        // Validação do preço
        const preco = $('#preco').val().replace(',', '.');
        const precoNum = parseFloat(preco);
        if(precoNum <= 0) {
            alert('O preço deve ser maior que zero');
            hasError = true;
        } else if(precoNum > 1000) {
            alert('O preço máximo permitido é R$ 1.000,00');
            hasError = true;
        }

        // Validação da quantidade
        const quantidade = parseInt($('#quantidade').val());
        if(quantidade <= 0) {
            alert('A quantidade deve ser maior que zero');
            hasError = true;
        } else if(quantidade > 1000) {
            alert('A quantidade máxima permitida é 1000');
            hasError = true;
        }

        // Validação do nome
        const nome = $('#nome').val().trim();
        if(nome.length < 2) {
            alert('O nome deve ter pelo menos 2 caracteres');
            hasError = true;
        }

        // Validação da descrição
        const descricao = $('#descricao').val().trim();
        if(descricao.length < 5) {
            alert('A descrição deve ter pelo menos 5 caracteres');
            hasError = true;
        }

        // Validação adicional da imagem
        const imagem = $('#imagem')[0].files[0];
        if(imagem) {
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if(!validTypes.includes(imagem.type)) {
                alert('Formato de imagem inválido! Use apenas JPG, JPEG, PNG ou WEBP.');
                hasError = true;
            }
            
            if(imagem.size > 4 * 1024 * 1024) {
                alert('A imagem deve ter no máximo 4MB');
                hasError = true;
            }

            const fileName = imagem.name.toLowerCase();
            const validExtensions = ['.jpg', '.jpeg', '.png', '.webp'];
            const hasValidExtension = validExtensions.some(ext => fileName.endsWith(ext));
            
            if(!hasValidExtension) {
                alert('Formato de imagem inválido! Use apenas JPG, JPEG, PNG ou WEBP.');
                hasError = true;
            }
        }

        if(hasError) {
            e.preventDefault();
            return false;
        }
    });
});
</script>
@endsection
