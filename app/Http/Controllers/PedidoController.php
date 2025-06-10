<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Cardapio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PedidoController extends Controller
{
    public function processOrder(Request $request)
    {
        $request->validate([
            'nome_cliente' => 'required|string|max:255',
            'telefone_cliente' => ['required', 'string', 'min:10', 'max:20', 'regex:/^\\d[\\d\\s\\(\\)\\-+\\.]+$/'],
            'endereco_entrega' => 'required|string|max:255',
            'horario_entrega' => 'required|string|max:50',
            'observacoes' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $carrinho = Session::get('carrinho', []);

        if (empty($carrinho)) {
            return back()->with('erro', 'Seu carrinho está vazio.');
        }

        // Criar o pedido
        $pedido = Pedido::create([
            'user_id' => $user->id,
            'nome_cliente' => $request->input('nome_cliente'),
            'telefone_cliente' => $request->input('telefone_cliente'),
            'endereco_entrega' => $request->input('endereco_entrega'),
            'horario_entrega' => $request->input('horario_entrega'),
            'observacoes' => $request->input('observacoes'),
            'status' => 'pendente',
            'total' => 0,
        ]);

        $totalPedido = 0;
        foreach ($carrinho as $cardapio_id => $item) {
            PedidoItem::create([
                'pedido_id' => $pedido->id,
                'cardapio_id' => $cardapio_id,
                'quantidade' => $item['quantidade'],
                'preco_unitario' => $item['preco'],
            ]);
            $totalPedido += $item['preco'] * $item['quantidade'];
        }

        // Atualizar o total do pedido
        $pedido->total = $totalPedido;
        $pedido->save();

        // Limpar o carrinho da sessão
        Session::forget('carrinho');

        return redirect()->route('pedidos.confirmacao', $pedido->id)->with('sucesso', 'Pedido realizado com sucesso!');
    }

    public function showOrderConfirmation(Pedido $pedido)
    {
        // Certificar-se de que o pedido pertence ao usuário logado, se necessário
        if ($pedido->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado a este pedido.');
        }

        // Carregar os itens do pedido com os detalhes do cardápio
        $pedido->load('items.cardapio');

        return view('pedidos.confirmacao', compact('pedido'));
    }
}
