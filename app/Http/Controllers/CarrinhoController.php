<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cardapio;
use Illuminate\Support\Facades\Validator;

class CarrinhoController extends Controller
{
    // Adiciona item ao carrinho (JSON)
    public function adicionar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cardapio_id' => 'required|exists:cardapios,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $cardapio = Cardapio::find($data['cardapio_id']);

        if ($data['quantidade'] > $cardapio->quantidade) {
            return response()->json(['errors' => ['quantidade' => ['Quantidade maior que o estoque']]], 422);
        }

        $carrinho = session()->get('carrinho', []);
        if (isset($carrinho[$cardapio->id])) {
            $carrinho[$cardapio->id]['quantidade'] += $data['quantidade'];
        } else {
            $carrinho[$cardapio->id] = [
                'nome' => $cardapio->nome,
                'quantidade' => $data['quantidade'],
                'validade' => $cardapio->validade,
                'preco' => $cardapio->preco,
            ];
        }
        session()->put('carrinho', $carrinho);
        return response()->json(['message' => 'Item adicionado ao carrinho'], 200);
    }

    // Remove item do carrinho (JSON)
    public function remover($id)
    {
        $carrinho = session()->get('carrinho', []);
        if (isset($carrinho[$id])) {
            unset($carrinho[$id]);
            session()->put('carrinho', $carrinho);
            return response()->json(['message' => 'Item removido do carrinho'], 200);
        }
        return response()->json(['errors' => ['item' => ['Item não encontrado no carrinho']]], 404);
    }

    // Limpa o carrinho (JSON)
    public function limpar()
    {
        session()->forget('carrinho');
        return response()->json(['message' => 'Carrinho limpo com sucesso'], 200);
    }
}
