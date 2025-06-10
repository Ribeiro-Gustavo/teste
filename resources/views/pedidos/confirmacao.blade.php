@extends('layouts.menuLateral')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background-color:#111111;">
    <div class="max-w-xl w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-4xl font-bold text-white mb-2">Pedido Realizado com Sucesso!</h2>
            <p class="text-gray-400 text-lg">Acompanhe os detalhes do seu pedido abaixo.</p>
        </div>

        <!-- Success Message -->
        @if(session('sucesso'))
            <div class="bg-green-600 border border-green-500 text-white px-4 py-3 rounded-lg shadow-lg text-center">
                <i class="fas fa-check-circle mr-2"></i>{{ session('sucesso') }}
            </div>
        @endif

        <!-- Order Details Card -->
        <div class="rounded-2xl shadow-2xl overflow-hidden" style="background-color:#181818; border:1px solid #222222;">
            <div class="p-8">
                <h3 class="text-2xl font-bold text-white mb-6"><i class="fas fa-receipt mr-2 text-primary-500"></i>Detalhes do Pedido #{{ $pedido->id }}</h3>

                <div class="space-y-4 mb-6" style="color:#bdbdbd;">
                    <p><strong>Status:</strong> <span class="font-semibold text-primary-400">{{ ucfirst($pedido->status) }}</span></p>
                    <p><strong>Nome do Cliente:</strong> {{ $pedido->nome_cliente }}</p>
                    <p><strong>Telefone do Cliente:</strong> {{ $pedido->telefone_cliente }}</p>
                    <p><strong>Endereço de Entrega:</strong> {{ $pedido->endereco_entrega }}</p>
                    <p><strong>Horário de Entrega:</strong> {{ $pedido->horario_entrega }}</p>
                    @if($pedido->observacoes)
                        <p><strong>Observações:</strong> {{ $pedido->observacoes }}</p>
                    @endif
                    <p><strong>Data do Pedido:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <h4 class="text-xl font-bold text-white mb-4"><i class="fas fa-list-alt mr-2 text-primary-500"></i>Itens do Pedido</h4>
                <div class="space-y-3 mb-6">
                    @foreach($pedido->items as $item)
                        <div class="flex justify-between items-center text-white bg-gray-700 p-3 rounded-lg" style="background-color:#222222;">
                            <span>{{ $item->cardapio->nome }} ({{ $item->quantidade }}x)</span>
                            <span>R$ {{ number_format($item->quantidade * $item->preco_unitario, 2, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t pt-4 flex justify-between items-center" style="border-top:1px solid #222222;">
                    <span class="font-bold text-white text-2xl">Total do Pedido:</span>
                    <span class="font-bold text-primary-500 text-2xl">R$ {{ number_format($pedido->total, 2, ',', '.') }}</span>
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ route('home') }}"
                       class="w-full text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl inline-flex items-center justify-center space-x-2"
                       style="background-color:#f97316; hover:background-color:#ea580c;">
                        <i class="fas fa-home"></i>
                        <span>Voltar para a Página Inicial</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
