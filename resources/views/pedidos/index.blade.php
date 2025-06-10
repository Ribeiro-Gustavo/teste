@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Meus Pedidos</h1>
            <a href="{{ route('home') }}" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Voltar
            </a>
        </div>

        @if(session('sucesso'))
            <div class="bg-green-600 border border-green-500 text-white px-4 py-3 rounded-lg shadow-lg mb-6">
                {{ session('sucesso') }}
            </div>
        @endif

        @if($pedidos->isEmpty())
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 text-center">
                <i class="fas fa-shopping-bag text-4xl text-gray-600 mb-4"></i>
                <p class="text-gray-400">Você ainda não fez nenhum pedido.</p>
                <a href="{{ route('home') }}" class="inline-block mt-4 bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-lg transition-colors duration-200">
                    Fazer um Pedido
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($pedidos as $pedido)
                    <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h2 class="text-lg font-semibold text-white">Pedido #{{ $pedido->id }}</h2>
                                    <p class="text-sm text-gray-400">{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    @if($pedido->status === 'pendente') bg-yellow-600 text-yellow-100
                                    @elseif($pedido->status === 'preparando') bg-blue-600 text-blue-100
                                    @elseif($pedido->status === 'entregue') bg-green-600 text-green-100
                                    @else bg-gray-600 text-gray-100
                                    @endif">
                                    {{ ucfirst($pedido->status) }}
                                </span>
                            </div>

                            <div class="space-y-4">
                                <!-- Itens do Pedido -->
                                <div class="bg-gray-700 rounded-lg p-4">
                                    <h3 class="text-sm font-medium text-gray-400 mb-3">Itens do Pedido</h3>
                                    <div class="space-y-2">
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
                                    <h3 class="text-sm font-medium text-gray-400 mb-3">Informações de Entrega</h3>
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
                                <div class="flex justify-between items-center bg-gray-700 rounded-lg p-4">
                                    <span class="text-lg font-semibold text-white">Total do Pedido</span>
                                    <span class="text-xl font-bold text-primary-500">R$ {{ number_format($pedido->total, 2, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection 