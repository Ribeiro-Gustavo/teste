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
    @else
        <p>Carrinho vazio.</p>
    @endif
</div>
