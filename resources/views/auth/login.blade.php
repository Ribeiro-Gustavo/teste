@extends('layouts.app')

@section('content')
<h1>Login</h1>

@if($errors->any())
    <p style="color: red;">{{ $errors->first() }}</p>
@endif

<form action="{{ route('login') }}" method="POST">
    @csrf
    <input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required>
    <input type="password" name="password" placeholder="Senha" required>
    <button type="submit">Entrar</button>
</form>

<hr>

<p>Não tem conta? <a href="{{ route('register') }}">Crie uma agora</a></p>
@endsection
