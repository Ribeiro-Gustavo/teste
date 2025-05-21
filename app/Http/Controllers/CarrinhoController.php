<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alimento;

class CarrinhoController extends Controller
{
    public function adicionar(Request $request, $id)
    {
        $alimento = Alimento::findOrFail($id);
        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$id])) {
            $carrinho[$id]['quantidade']++;
        } else {
            $carrinho[$id] = [
                'nome' => $alimento->nome,
                'quantidade' => 1,
                'validade' => $alimento->validade,
            ];
        }

        session()->put('carrinho', $carrinho);
        return back()->with('sucesso', 'Item adicionado ao carrinho!');
    }

    public function mostrar()
    {
        $carrinho = session()->get('carrinho', []);
        return view('carrinho.modal', compact('carrinho'));
    }

public function remover(Request $request, $id)
{
    $carrinho = session()->get('carrinho', []);

    if (isset($carrinho[$id])) {
        $quantidadeRemover = (int) $request->input('quantidade', 1);

        if ($carrinho[$id]['quantidade'] > $quantidadeRemover) {
            $carrinho[$id]['quantidade'] -= $quantidadeRemover;
        } else {
            unset($carrinho[$id]);
        }

        session()->put('carrinho', $carrinho);
    }

    return back()->with('sucesso', 'Item atualizado no carrinho.');
}

    public function limpar()
    {
        session()->forget('carrinho');
        return back()->with('sucesso', 'Carrinho limpo!');
    }
}
