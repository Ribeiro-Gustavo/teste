<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cardapio;
use Illuminate\Support\Facades\Storage;

class CardapioController extends Controller
{
    public function index()
    {
        $cardapios = Cardapio::all();
        $carrinho = session()->get('carrinho', []);
        return view('cardapios.index', compact('cardapios', 'carrinho'));
    }

    public function create()
    {
        return view('cardapios.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|min:2|max:25',
            'quantidade' => 'required|integer|min:0|max:9999',
            'validade' => 'nullable|date',
            'preco' => 'required|numeric|min:0.01|max:9999.99|regex:/^\d+(\.\d{1,2})?$/',
            'descricao' => 'required|string|min:5|max:125',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Upload da imagem
        if ($request->hasFile('imagem')) {
            $validatedData['imagem'] = $request->file('imagem')->store('cardapios', 'public');
        }

        Cardapio::create($validatedData);

        return redirect()->route('cardapios.index')->with('sucesso', 'Cardápio adicionado!');
    }

    public function edit(Cardapio $cardapio)
    {
        return view('cardapios.edit', compact('cardapio'));
    }

    public function update(Request $request, $id)
    {
        $cardapio = Cardapio::findOrFail($id);
        $validatedData = $request->validate([
            'nome' => 'required|string|min:2|max:25',
            'quantidade' => 'required|integer|min:0|max:9999',
            'validade' => 'nullable|date',
            'preco' => 'required|numeric|min:0.01|max:9999.99|regex:/^\d+(\.\d{1,2})?$/',
            'descricao' => 'required|string|min:5|max:125',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Se enviou uma nova imagem, faz upload e atualiza o campo
        if ($request->hasFile('imagem')) {
            // Opcional: Apagar a imagem antiga do storage
            if ($cardapio->imagem && \Storage::disk('public')->exists($cardapio->imagem)) {
                \Storage::disk('public')->delete($cardapio->imagem);
            }
            $validatedData['imagem'] = $request->file('imagem')->store('cardapios', 'public');
        }

        $cardapio->update($validatedData);

        return redirect()->route('cardapios.index')->with('sucesso', 'Cardápio atualizado!');
    }

    public function destroy($id)
    {
        $cardapio = Cardapio::findOrFail($id);
        // Apaga a imagem associada antes de deletar o cardápio
        if ($cardapio->imagem && \Storage::disk('public')->exists($cardapio->imagem)) {
            \Storage::disk('public')->delete($cardapio->imagem);
        }

        $cardapio->delete();

        return redirect()->route('cardapios.index')->with('sucesso', 'Cardápio removido!');
    }
}
