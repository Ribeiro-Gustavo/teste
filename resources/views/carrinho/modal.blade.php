<!-- MANTENDO EXATAMENTE A MESMA FUNCIONALIDADE DO MODAL ORIGINAL -->
<div id="carrinhoModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-hidden border border-gray-700">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-700 bg-gradient-to-r from-primary-600 to-primary-700">
            <h3 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-shopping-cart mr-3"></i>
                Itens no Carrinho
            </h3>
            <!-- MANTENDO A FUNÇÃO toggleCarrinho() ORIGINAL -->
            <button onclick="toggleCarrinho()" class="text-white hover:text-gray-200 focus:outline-none transition-colors duration-200">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Content -->
        <div class="p-6 overflow-y-auto max-h-96">
            <!-- MANTENDO EXATAMENTE A LÓGICA PHP ORIGINAL -->
            @if(count($carrinho) > 0)
                <div class="space-y-4">
                    @foreach($carrinho as $id => $item)
                        <div class="bg-gray-700 rounded-xl p-4 border border-gray-600">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-white">{{ $item['nome'] }}</h4>
                                    <p class="text-gray-400 text-sm">{{ $item['quantidade'] }} unidades</p>
                                </div>

                                <!-- MANTENDO EXATAMENTE O FORM ORIGINAL -->
                                <form action="{{ route('carrinho.remover', $id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="number" name="quantidade" value="1" min="1" max="{{ $item['quantidade'] }}" class="w-16 px-2 py-1 bg-gray-600 border border-gray-500 rounded text-white text-sm" />
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded ml-2 text-sm transition-colors duration-200">
                                        Remover
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- MANTENDO EXATAMENTE OS FORMS ORIGINAIS -->
                <div class="mt-6 pt-6 border-t border-gray-700">
                    <div class="grid grid-cols-2 gap-3">
                        <form action="{{ route('carrinho.limpar') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded-lg font-semibold transition-colors duration-200">
                                Limpar Carrinho
                            </button>
                        </form>

                        <!-- MANTENDO A FUNÇÃO abrirFinalizarPedidoModal() ORIGINAL -->
                        <button onclick="abrirFinalizarPedidoModal()"
                                class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 px-4 rounded-lg font-semibold transition-colors duration-200">
                            Finalizar Pedido
                        </button>
                    </div>
                </div>
            @else
                <!-- MANTENDO A LÓGICA ORIGINAL PARA CARRINHO VAZIO -->
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shopping-cart text-3xl text-gray-500"></i>
                    </div>
                    <p class="text-gray-400">Carrinho vazio.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- MANTENDO EXATAMENTE O MODAL DE FINALIZAR PEDIDO ORIGINAL -->
<div id="finalizarPedidoModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-60 flex items-center justify-center p-4">
    <div class="bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full border border-gray-700">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-700 bg-gradient-to-r from-green-600 to-green-700">
            <h3 class="text-xl font-bold text-white">Resumo do Pedido</h3>
            <!-- MANTENDO A FUNÇÃO fecharFinalizarPedidoModal() ORIGINAL -->
            <button onclick="fecharFinalizarPedidoModal()" class="text-white hover:text-gray-200 focus:outline-none transition-colors duration-200">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Content -->
        <div class="p-6">
            <!-- MANTENDO EXATAMENTE A LÓGICA PHP ORIGINAL -->
            @php $total = 0; @endphp
            @foreach($carrinho as $item)
                @php
                    $subtotal = $item['preco'] * $item['quantidade'];
                    $total += $subtotal;
                @endphp
                <div class="flex justify-between items-center py-2 border-b border-gray-700">
                    <span class="text-white">{{ $item['nome'] }} ({{ $item['quantidade'] }}x)</span>
                    <span class="text-primary-400 font-semibold">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                </div>
            @endforeach

            <div class="mt-4 pt-4 border-t border-gray-700">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xl font-semibold text-white">Total:</span>
                    <span class="text-2xl font-bold text-primary-400">R$ {{ number_format($total, 2, ',', '.') }}</span>
                </div>

                <!-- MANTENDO A FUNÇÃO fecharFinalizarPedidoModal() ORIGINAL -->
                <button onclick="fecharFinalizarPedidoModal()"
                        class="w-full bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded-lg font-semibold transition-colors duration-200">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MANTENDO EXATAMENTE TODAS AS FUNÇÕES JAVASCRIPT ORIGINAIS -->
<script>
    function toggleCarrinho() {
        const modal = document.getElementById('carrinhoModal');
        modal.classList.toggle('hidden');
    }

    function abrirFinalizarPedidoModal() {
        document.getElementById('finalizarPedidoModal').classList.remove('hidden');
    }

    function fecharFinalizarPedidoModal() {
        document.getElementById('finalizarPedidoModal').classList.add('hidden');
    }
</script>
