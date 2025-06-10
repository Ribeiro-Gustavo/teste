@extends('layouts.menuLateral')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-white">Cardápio</h1>
    </div>

    <!-- Lista de Produtos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($cardapios as $cardapio)
            <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-700">
                <div class="relative">
                    @if($cardapio->imagem)
                        <img src="{{ asset('storage/' . $cardapio->imagem) }}" alt="{{ $cardapio->nome }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-700 flex items-center justify-center">
                            <i class="fas fa-utensils text-4xl text-gray-500"></i>
                        </div>
                    @endif
                    <div class="absolute top-2 right-2">
                        <span class="bg-primary-600 text-white px-2 py-1 rounded-full text-sm">
                            R$ {{ number_format($cardapio->preco, 2, ',', '.') }}
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-xl font-semibold text-white mb-2">{{ $cardapio->nome }}</h3>
                    <p class="text-gray-400 mb-4">{{ $cardapio->descricao }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            {{ $cardapio->tempo_preparo }} min
                        </span>
                        <form action="{{ route('carrinho.adicionar', $cardapio->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                                <i class="fas fa-plus mr-2"></i>Adicionar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
function toggleCarrinho() {
    const modal = document.getElementById('carrinhoModal');
    modal.classList.toggle('hidden');
}

// Máscara para telefone
document.addEventListener('DOMContentLoaded', function() {
    const telefoneInput = document.getElementById('telefone_cliente');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);
            
            if (value.length > 2) {
                value = `(${value.slice(0, 2)}) ${value.slice(2)}`;
            }
            if (value.length > 9) {
                value = `${value.slice(0, 9)}-${value.slice(9)}`;
            }
            
            e.target.value = value;
        });
    }
});
</script>
@endsection
