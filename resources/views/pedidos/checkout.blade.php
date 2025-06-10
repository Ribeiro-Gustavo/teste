@extends('layouts.menuLateral')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background-color:#111111;">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-4xl font-bold text-white mb-2">Finalizar Pedido</h2>
            <p class="text-gray-400 text-lg">Informe os detalhes da entrega</p>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="bg-red-600 border border-red-500 text-white px-4 py-3 rounded-lg shadow-lg">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle mr-2 mt-0.5"></i>
                    <div>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Carrinho Summary (optional, but good for context) -->
        <div class="rounded-2xl shadow-2xl overflow-hidden" style="background-color:#181818; border:1px solid #222222;">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-white mb-4">Itens do Carrinho</h3>
                <div class="space-y-3 mb-4">
                    @foreach($carrinho as $item)
                        <div class="flex justify-between items-center text-white">
                            <span>{{ $item['nome'] }} ({{ $item['quantidade'] }}x)</span>
                            <span>R$ {{ number_format($item['preco'] * $item['quantidade'], 2, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="border-t pt-4 flex justify-between items-center" style="border-top:1px solid #222222;">
                    <span class="font-bold text-white text-xl">Total:</span>
                    <span class="font-bold text-primary-500 text-xl">R$ {{ number_format($total, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="rounded-2xl shadow-2xl overflow-hidden" style="background-color:#181818; border:1px solid #222222;">
            <div class="p-8">
                <form action="{{ route('checkout.process') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Endereço de Entrega -->
                    <div>
                        <label for="endereco_entrega" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-primary-500"></i>Endereço de Entrega
                        </label>
                        <input type="text"
                               name="endereco_entrega"
                               value="{{ old('endereco_entrega') }}"
                               required
                               class="w-full px-4 py-3 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                               style="background-color:#222222; border:1px solid #333333;"
                               placeholder="Ex: Rua Exemplo, 123 - Bairro - Cidade/UF">
                    </div>

                    <!-- Observações (Opcional) -->
                    <div>
                        <label for="observacoes" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-comment-alt mr-2 text-primary-500"></i>Observações (opcional)
                        </label>
                        <textarea name="observacoes"
                                  rows="3"
                                  class="w-full px-4 py-3 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                  style="background-color:#222222; border:1px solid #333333;"
                                  placeholder="Ex: Sem cebola, entregar no vizinho, etc.">{{ old('observacoes') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2"
                            style="background-color:#f97316; hover:background-color:#ea580c;">
                        <i class="fas fa-check"></i>
                        <span>Finalizar Pedido</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
