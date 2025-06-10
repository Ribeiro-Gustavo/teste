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
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'nome_cliente' => 'required|string|max:255',
            'telefone_cliente' => ['required', 'string', 'min:10', 'max:20', 'regex:/^\\d[\\d\\s\\(\\)\\-+\\.]+$/'],
            'endereco_entrega' => 'required|string|max:255',
            'horario_entrega' => 'required|string|max:50',
            'observacoes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();
        $carrinho = Session::get('carrinho', []);

        if (empty($carrinho)) {
            return response()->json(['errors' => ['itens' => ['Seu carrinho está vazio.']]], 422);
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

        return response()->json(['message' => 'Pedido criado com sucesso', 'pedido_id' => $pedido->id], 201);
    }

    public function showOrderConfirmation(Pedido $pedido)
    {
        // Esta função deve retornar uma view, mas os testes esperam JSON.
        // No contexto de API, seria um método `show` para retornar os detalhes do pedido.
        // Mantenho a lógica de autorização aqui para consistência.
        if ($pedido->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado a este pedido.');
        }
        $pedido->load('items.cardapio');
        return response()->json(['data' => $pedido], 200);
    }

    public function index()
    {
        $pedidos = Auth::user()->pedidos()->with('items.cardapio')->get();
        return response()->json(['data' => $pedidos], 200);
    }

    public function show(Pedido $pedido)
    {
        if ($pedido->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado a este pedido.');
        }
        $pedido->load('items.cardapio');
        return response()->json(['data' => $pedido], 200);
    }

    public function cancel(Pedido $pedido)
    {
        if ($pedido->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado para cancelar este pedido.');
        }

        if ($pedido->status === 'em_preparo') {
            return response()->json(['message' => 'Não é possível cancelar um pedido em preparo'], 403);
        }

        $pedido->status = 'cancelado';
        $pedido->save();

        return response()->json(['message' => 'Pedido cancelado com sucesso'], 200);
    }
}
