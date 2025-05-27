@extends('layouts.menuLateral')

@section('content')
<h1>Editar Cardápio</h1>

<form action="{{ route('cardapios.update', $cardapio) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Nome:</label><br>
    <input type="text" name="nome" value="{{ old('nome', $cardapio->nome) }}" maxlength="25" required><br><br>

    <label>Quantidade:</label><br>
    <input type="number" name="quantidade" value="{{ old('quantidade', $cardapio->quantidade) }}" min="0" required><br><br>

    <label>Preço:</label><br>
    <input type="number" name="preco" value="{{ old('preco', $cardapio->preco) }}" min="0" step="0.01" required><br><br>

    <label>Descrição:</label><br>
    <textarea name="descricao" maxlength="125" required>{{ old('descricao', $cardapio->descricao) }}</textarea><br><br>

    <label>Imagem atual:</label><br>
    @if($cardapio->imagem)
        <img src="{{ asset('storage/' . $cardapio->imagem) }}" alt="Imagem do {{ $cardapio->nome }}" style="width: 150px; margin-bottom: 10px;">
    @else
        <p>Sem imagem cadastrada.</p>
    @endif
    <br>

    <label>Nova imagem (opcional):</label><br>
    <input type="file" name="imagem" accept="image/*"><br><br>

    <button type="submit">Atualizar</button>
</form>
@endsection
