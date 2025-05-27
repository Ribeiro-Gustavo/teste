@extends('layouts.menuLateral')

@section('content')
<h1 style="text-align:center; margin-bottom: 30px;">Nosso Cardápio</h1>

@if(session('sucesso'))
    <p style="color: green; text-align:center;">{{ session('sucesso') }}</p>
@endif

<div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
    @foreach($cardapios as $cardapio)
    <div style="border: 1px solid #ccc; border-radius: 8px; width: 30%; box-sizing: border-box; padding: 15px; text-align: center;">
        @if($cardapio->imagem)
            <img src="{{ asset('storage/' . $cardapio->imagem) }}" alt="{{ $cardapio->nome }}" style="width: 100%; height: 180px; object-fit: cover; border-radius: 5px;">
        @else
            <div style="width: 100%; height: 180px; background-color: #eee; display: flex; align-items: center; justify-content: center; color: #999; border-radius: 5px;">
                Sem imagem
            </div>
        @endif
        
        <h3 style="margin: 15px 0 10px;">{{ $cardapio->nome }}</h3>
        <p style="min-height: 60px;">{{ $cardapio->descricao }}</p>
        <p style="font-weight: bold; font-size: 1.1rem; margin-bottom: 15px;">R$ {{ number_format($cardapio->preco, 2, ',', '.') }}</p>

        <form action="{{ route('carrinho.adicionar', $cardapio->id) }}" method="POST">
            @csrf
            <button type="submit" style="background-color: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
                Adicionar ao Carrinho
            </button>
        </form>
    </div>
    @endforeach
</div>
@endsection
