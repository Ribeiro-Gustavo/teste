@extends('layouts.menuLateral')

@section('content')
<h1>Crie sua Conta</h1>

@if($errors->any())
    <ul style="color: red;">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('register') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Nome" value="{{ old('name') }}" required>
    <input type="email" name="email" placeholder="E‑mail" value="{{ old('email') }}" required>
    <input type="password" name="password" placeholder="Senha (mínimo 6)" required>
    <input type="password" name="password_confirmation" placeholder="Confirme a senha" required>
    <button type="submit">Registrar‑me</button>
</form>
@endsection
