<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cardapio;
use Illuminate\Support\Facades\Validator;

class CarrinhoController extends Controller
{
    // Adiciona item ao carrinho (JSON ou Form)
    public function adicionar(Request $request, $id = null)
    {
        // Se o ID vier da URL, usa ele
        $cardapio_id = $id ?? $request->input('cardapio_id');
        $quantidade = $request->input('quantidade', 1);

        $validator = Validator::make([
            'cardapio_id' => $cardapio_id,
            'quantidade' => $quantidade
        ], [
            'cardapio_id' => 'required|exists:cardapios,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $cardapio = Cardapio::find($cardapio_id);

        if ($quantidade > $cardapio->quantidade) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => ['quantidade' => ['Quantidade maior que o estoque']]], 422);
            }
            return back()->withErrors(['quantidade' => 'Quantidade maior que o estoque'])->withInput();
        }

        $carrinho = session()->get('carrinho', []);
        if (isset($carrinho[$cardapio->id])) {
            $carrinho[$cardapio->id]['quantidade'] += $quantidade;
        } else {
            $carrinho[$cardapio->id] = [
                'nome' => $cardapio->nome,
                'quantidade' => $quantidade,
                'validade' => $cardapio->validade,
                'preco' => $cardapio->preco,
            ];
        }
        session()->put('carrinho', $carrinho);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Item adicionado ao carrinho'], 200);
        }
        return back()->with('sucesso', 'Item adicionado ao carrinho');
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
