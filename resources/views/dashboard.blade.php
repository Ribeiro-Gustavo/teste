{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.menuLateral')

@section('content')
  <h1>Dashboard</h1>
  <p>Você está logado como <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }})</p>
  <p><a href="{{ route('cardapios.index') }}">Ir para lista de cardapios</a></p>
@endsection
