@extends('layouts.menuLateral')

@section('content')
<h1>Lista de Cardápios</h1>

@if(session('sucesso'))
    <p style="color: green;">{{ session('sucesso') }}</p>
@endif

<a href="{{ route('cardapios.create') }}">Adicionar Novo Cardápio</a>

<ul>
@foreach($cardapios as $cardapio)
    <li style="margin-bottom: 20px;">
        <strong>{{ $cardapio->nome }}</strong><br>
        Quantidade: {{ $cardapio->quantidade }}<br>
        Preço: R$ {{ number_format($cardapio->preco, 2, ',', '.') }}<br>
        Descrição: {{ $cardapio->descricao }}<br>
        
        {{-- Imagem pequena --}}
        @if($cardapio->imagem)
            <img src="{{ asset('storage/' . $cardapio->imagem) }}" alt="{{ $cardapio->nome }}" style="width: 100px; height: auto; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;">
        @else
            <p><i>Sem imagem disponível</i></p>
        @endif

        <br>
        <a href="{{ route('cardapios.edit', $cardapio) }}">Editar</a>

        <form action="{{ route('cardapios.destroy', $cardapio) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Excluir</button>
        </form>

        <form action="{{ route('carrinho.adicionar', $cardapio->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">Adicionar ao carrinho</button>
        </form>
    </li>
@endforeach
</ul>
@endsection

{{-- Modal do Carrinho --}}
@section('modal')
<div id="carrinhoModal" style="display:none; position:fixed; right:10px; top:50px; background:#fff; border:1px solid #ccc; padding:20px; z-index: 1000;">
    <h3>Itens no Carrinho</h3>

    @if(count($carrinho) > 0)
        <ul>
            @foreach($carrinho as $id => $item)
                <li>
                    {{ $item['nome'] }} - {{ $item['quantidade'] }} unidades
                    <form action="{{ route('carrinho.remover', $id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="color: red; background: none; border: none; cursor: pointer;">X</button>
                    </form>
                </li>
            @endforeach
        </ul>

        <form action="{{ route('carrinho.limpar') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" style="background: red; color: white; padding: 5px 10px; border: none; cursor: pointer;">
                Limpar Carrinho
            </button>
        </form>
        <button onclick="toggleCarrinho()" style="background: gray; color: white; padding: 5px 10px; border: none; cursor: pointer;">
            Fechar
        </button>
    @else
        <p>Carrinho vazio.</p>
    @endif
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
