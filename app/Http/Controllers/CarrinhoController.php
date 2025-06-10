<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cardapio;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CarrinhoController extends Controller
{
    private function getCarrinhoKey()
    {
        return Auth::check() ? 'carrinho_' . Auth::id() : 'carrinho_guest';
    }

    // Adiciona item ao carrinho (JSON ou Form)
    public function adicionar(Request $request, $id)
    {
        $cardapio = Cardapio::findOrFail($id);
        $quantidade = $request->input('quantidade', 1);
        
        $carrinho = session()->get($this->getCarrinhoKey(), []);
        
        if(isset($carrinho[$id])) {
            $carrinho[$id]['quantidade'] += $quantidade;
        } else {
            $carrinho[$id] = [
                'nome' => $cardapio->nome,
                'quantidade' => $quantidade,
                'preco' => $cardapio->preco,
                'imagem' => $cardapio->imagem
            ];
        }
        
        session()->put($this->getCarrinhoKey(), $carrinho);
        
        return redirect()->back()->with('sucesso', 'Item adicionado ao carrinho!');
    }

    // Remove item do carrinho
    public function remover($id)
    {
        $carrinho = session()->get($this->getCarrinhoKey(), []);
        
        if(isset($carrinho[$id])) {
            unset($carrinho[$id]);
            session()->put($this->getCarrinhoKey(), $carrinho);
            return redirect()->back()->with('sucesso', 'Item removido do carrinho!');
        }
        
        return redirect()->back()->with('erro', 'Item não encontrado no carrinho!');
    }

    // Limpa o carrinho
    public function limpar()
    {
        session()->forget($this->getCarrinhoKey());
        return redirect()->back()->with('sucesso', 'Carrinho limpo com sucesso!');
    }

    // Mostra o carrinho
    public function index()
    {
        $carrinho = session()->get($this->getCarrinhoKey(), []);
        return view('carrinho.index', compact('carrinho'));
    }
}
