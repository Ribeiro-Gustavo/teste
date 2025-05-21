{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
  <h1>Dashboard</h1>
  <p>Você está logado como <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }})</p>
  <p><a href="{{ route('alimentos.index') }}">Ir para lista de alimentos</a></p>
@endsection
