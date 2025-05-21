@extends('layouts.app')

@section('content')
<h1>Lista de Alimentos</h1>

@if(session('sucesso'))
<p style="color: green;">{{ session('sucesso') }}</p>
@endif

<a href="{{ route('alimentos.create') }}">Adicionar Novo Alimento</a>

<ul>
@foreach($alimentos as $alimento)
<li>
<strong>{{ $alimento->nome }}</strong> -
Quantidade: {{ $alimento->quantidade }} -
Validade: {{ $alimento->validade ?? 'Sem validade' }}

<a href="{{ route('alimentos.edit', $alimento) }}">Editar</a>

<form action="{{ route('alimentos.destroy', $alimento) }}" method="POST"
style="display:inline;">
@csrf
@method('DELETE')
<button type="submit">Excluir</button>
</form>

<form action="{{ route('carrinho.adicionar', $alimento->id) }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit">Adicionar ao carrinho</button>
</form>
</li>
@endforeach
</ul>

@endsection
@section('content')
<!-- ... o conteúdo atual que você já tem ... -->
@endsection

{{-- Modal do Carrinho --}}
<div id="carrinhoModal" style="display:none; position:fixed; right:10px; top:50px; background:#fff; border:1px solid #ccc; padding:20px;">
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

<script>
    function toggleCarrinho() {
        const modal = document.getElementById('carrinhoModal');
        modal.style.display = modal.style.display === 'none' ? 'block' : 'none';
    }
</script>
