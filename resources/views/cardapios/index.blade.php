@extends('layouts.menuLateral')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, #111111 0%, #181818 50%, #111111 100%);">
    <!-- Header -->
    <div class="py-12" style="background: linear-gradient(90deg, #f97316 0%, #c2410c 100%);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">Gerenciar Cardápio</h1>
                    <p class="text-xl text-primary-100">Administre seus produtos</p>
                </div>
                <a href="{{ route('cardapios.create') }}" class="mt-4 md:mt-0 bg-white text-primary-600 hover:bg-gray-100 font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>Adicionar Produto</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('sucesso'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            <div class="bg-green-600 border border-green-500 text-white px-4 py-3 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('sucesso') }}
                </div>
            </div>
        </div>
    @endif

    <!-- Products Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($cardapios->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($cardapios as $cardapio)
                    <div class="rounded-xl shadow-xl overflow-hidden border border-gray-700 hover:border-primary-500 transition-all duration-300" style="background-color:#181818;">
                        <!-- Image -->
                        <div class="relative h-48 overflow-hidden flex items-center justify-center bg-black">
                            @if($cardapio->imagem)
                                <img src="{{ asset('storage/' . $cardapio->imagem) }}"
                                     alt="{{ $cardapio->nome }}"
                                     class="w-full h-full object-cover object-center rounded-t-xl transition-transform duration-300 hover:scale-105 shadow-md">
                            @else
                                <div class="w-full h-full flex items-center justify-center" style="background-color:#222222;">
                                    <i class="fas fa-image text-4xl" style="color:#757575;"></i>
                                </div>
                            @endif
                            <div class="absolute top-2 right-2 bg-primary-600 text-white px-2 py-1 rounded-full text-sm font-semibold shadow">
                                R$ {{ number_format($cardapio->preco, 2, ',', '.') }}
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $cardapio->nome }}</h3>
                            <p class="text-gray-400 text-sm mb-2">Quantidade: {{ $cardapio->quantidade }}</p>
                            <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ $cardapio->descricao }}</p>

                            <!-- Actions -->
                            <div class="flex space-x-2">
                                <a href="{{ route('cardapios.edit', $cardapio) }}" class="flex-1 bg-gray-900 hover:bg-gray-800 text-white py-2 px-4 rounded-lg text-center transition-colors duration-200 flex items-center justify-center space-x-1">
                                    <i class="fas fa-edit"></i>
                                    <span>Editar</span>
                                </a>

                                <form action="{{ route('cardapios.destroy', $cardapio) }}" method="POST" class="flex-1" onsubmit="return confirm('Tem certeza que deseja excluir este produto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-1">
                                        <i class="fas fa-trash"></i>
                                        <span>Excluir</span>
                                    </button>
                                </form>
                            </div>

                            <!-- Add to Cart -->
                            <form action="{{ route('carrinho.adicionar', $cardapio->id) }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-1">
                                    <i class="fas fa-cart-plus"></i>
                                    <span>Adicionar ao Carrinho</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <i class="fas fa-utensils text-6xl text-gray-600 mb-4"></i>
                <h3 class="text-2xl font-semibold text-gray-400 mb-4">Nenhum produto cadastrado</h3>
                <p class="text-gray-500 mb-8">Comece adicionando seu primeiro produto ao cardápio!</p>
                <a href="{{ route('cardapios.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 inline-flex items-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>Adicionar Primeiro Produto</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection


@section('scripts')
<script>
    function toggleCarrinho() {
        const modal = document.getElementById('carrinhoModal');
        modal.style.display = modal.style.display === 'none' ? 'block' : 'none';
    }
</script>
@endsection
