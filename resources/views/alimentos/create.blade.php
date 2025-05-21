@extends('layouts.app')

@section('content')
<h1>Adicionar Alimento</h1>

<form action="{{ route('alimentos.store') }}" method="POST">
@csrf
<input type="text" name="nome" placeholder="Nome" required>
<input type="number" name="quantidade" placeholder="Quantidade" required>
<input type="date" name="validade">
<button type="submit">Salvar</button>
</form>
@endsection