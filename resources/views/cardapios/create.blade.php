@extends('layouts.menuLateral')

@section('content')
<h1>Adicionar Cardápio</h1>

<form action="{{ route('cardapios.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="nome" placeholder="Nome" maxlength="25" required>
    <input type="number" name="quantidade" placeholder="Quantidade" min="0" required>
    <input type="number" step="0.01" name="preco" placeholder="Preço" min="0" required>
    <input type="text" name="descricao" placeholder="Descrição" maxlength="125" required>
    <label for="imagem">Imagem do Produto:</label>
    <input type="file" name="imagem" accept="image/*" required>
    <button type="submit">Salvar</button>
</form>
@endsection
