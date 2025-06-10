@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="text-center mb-6">
                    <i class="fas fa-check-circle text-5xl text-green-500 mb-4"></i>
                    <h1 class="text-2xl font-bold text-white">Pedido Confirmado!</h1>
                    <p class="text-gray-400 mt-2">Seu pedido foi recebido e está sendo processado.</p>
                </div>

                <div class="space-y-6">
                    <!-- Informações do Cliente -->
                    <div class="bg-gray-700 rounded-lg p-4">
                        <h2 class="text-lg font-semibold text-white mb-3">Informações do Cliente</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-400">Nome</p>
                                <p class="text-white">{{ $pedido->nome_cliente }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Telefone</p>
                                <p class="text-white">{{ $pedido->telefone_cliente }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Itens do Pedido -->
                    <div class="bg-gray-700 rounded-lg p-4">
                        <h2 class="text-lg font-semibold text-white mb-3">Itens do Pedido</h2>
                        <div class="space-y-3">
                            @foreach($pedido->itens as $item)
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-white">{{ $item->cardapio->nome }}</p>
                                        <p class="text-sm text-gray-400">{{ $item->quantidade }}x - R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</p>
                                    </div>
                                    <p class="text-white font-semibold">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Informações de Entrega -->
                    <div class="bg-gray-700 rounded-lg p-4">
                        <h2 class="text-lg font-semibold text-white mb-3">Informações de Entrega</h2>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-gray-400">Endereço</p>
                                <p class="text-white">{{ $pedido->endereco_entrega }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Horário de Entrega</p>
                                <p class="text-white">{{ $pedido->horario_entrega }}</p>
                            </div>
                            @if($pedido->observacoes)
                                <div>
                                    <p class="text-sm text-gray-400">Observações</p>
                                    <p class="text-white">{{ $pedido->observacoes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Total do Pedido -->
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-white">Total do Pedido</span>
                            <span class="text-2xl font-bold text-primary-500">R$ {{ number_format($pedido->total, 2, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex space-x-4">
                        <a href="{{ route('home') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white text-center py-3 px-4 rounded-lg transition-colors duration-200">
                            <i class="fas fa-home mr-2"></i>Voltar ao Início
                        </a>
                        @if(Auth::check())
                            <a href="{{ route('pedidos.index') }}" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white text-center py-3 px-4 rounded-lg transition-colors duration-200">
                                <i class="fas fa-list mr-2"></i>Meus Pedidos
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
