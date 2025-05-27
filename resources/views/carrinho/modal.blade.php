<div id="carrinhoModal" style="display:none; position:fixed; right:10px; top:50px; background:#fff; border:1px solid #ccc; padding:20px; width:300px;">
    <h3 style="margin-top: 0;">Itens no Carrinho</h3>

    <button onclick="toggleCarrinho()" style="float:right; margin-top: -35px; margin-right: -10px; background:none; border:none; font-size:18px; cursor:pointer;">
        ✖
    </button>

    @if(count($carrinho) > 0)
        <ul style="padding-left: 20px;">
            @foreach($carrinho as $id => $item)
                <li>
                    {{ $item['nome'] }} - {{ $item['quantidade'] }} unidades
                    <form action="{{ route('carrinho.remover', $id) }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="number" name="quantidade" value="1" min="1" max="{{ $item['quantidade'] }}" style="width: 60px;" />
                        <button type="submit" style="color: red; background: none; border: none; cursor: pointer;">
                            Remover
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>

        <form action="{{ route('carrinho.limpar') }}" method="POST" style="margin-top: 15px;">
            @csrf
            <button type="submit" style="background: red; color: white; padding: 5px 10px; border: none; cursor: pointer;">
                Limpar Carrinho
            </button>
        </form>

        <button onclick="abrirFinalizarPedidoModal()" style="background: green; color: white; padding: 8px 15px; border: none; margin-top: 10px; cursor: pointer;">
            Finalizar Pedido
        </button>
    @else
        <p>Carrinho vazio.</p>
    @endif
</div>

<!-- MODAL DE FINALIZAR PEDIDO (inserido fora do carrinhoModal) -->
<div id="finalizarPedidoModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
    background: white; border: 1px solid #ccc; padding: 20px; width: 400px; box-shadow: 0 0 10px rgba(0,0,0,0.3); z-index: 9999;">
    
    <h3>Resumo do Pedido</h3>
    <ul style="list-style: none; padding: 0;">
        @php $total = 0; @endphp
        @foreach($carrinho as $item)
            @php
                $subtotal = $item['preco'] * $item['quantidade'];
                $total += $subtotal;
            @endphp
            <li>{{ $item['nome'] }} ({{ $item['quantidade'] }}x) - R$ {{ number_format($subtotal, 2, ',', '.') }}</li>
        @endforeach
    </ul>
    
    <p><strong>Total:</strong> R$ {{ number_format($total, 2, ',', '.') }}</p>
    
    <button onclick="fecharFinalizarPedidoModal()" style="margin-top: 15px; background: red; color: white; border: none; padding: 8px 15px; cursor: pointer;">
        Fechar
    </button>
</div>

<script>
    function abrirFinalizarPedidoModal() {
        document.getElementById('finalizarPedidoModal').style.display = 'block';
    }

    function fecharFinalizarPedidoModal() {
        document.getElementById('finalizarPedidoModal').style.display = 'none';
    }
</script>
