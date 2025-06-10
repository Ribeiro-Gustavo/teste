<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cardapio;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CardapioController extends Controller
{
    public function index()
    {
        $cardapios = Cardapio::all();
        $carrinho = session()->get(Auth::check() ? 'carrinho_' . Auth::id() : 'carrinho_guest', []);
        $isHomePage = request()->route()->getName() === 'home';
        return view('cardapios.index', compact('cardapios', 'carrinho', 'isHomePage'));
    }

    public function create()
    {
        return view('cardapios.create');
    }

    public function store(Request $request)
    {
        // Prepara o preço para validação (converte vírgula para ponto)
        $preco = str_replace(',', '.', $request->input('preco'));
        $request->merge(['preco' => $preco]);

        $validatedData = $request->validate([
            'nome' => ['required', 'string', 'min:2', 'max:25', 'regex:/^[a-zA-ZÀ-ÿ\s-]+$/'],
            'quantidade' => ['required', 'integer', 'min:1', 'max:1000'],
            'validade' => ['nullable', 'date', 'after:today'],
            'preco' => ['required', 'numeric', 'min:0.01', 'max:1000', 'regex:/^\d+(\.\d{1,2})?$/'],
            'descricao' => ['required', 'string', 'min:5', 'max:125', 'regex:/^[a-zA-ZÀ-ÿ0-9\s.,!?-]+$/'],
            'imagem' => [
                'required',
                'file',
                'max:4096',
                'mimes:jpeg,jpg,png,webp',
                function ($attribute, $value, $fail) {
                    // Verifica o MIME type real do arquivo
                    $mimeType = $value->getMimeType();
                    $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                    
                    if (!in_array($mimeType, $allowedMimes)) {
                        $fail('O arquivo deve ser uma imagem nos formatos: JPG, JPEG, PNG ou WEBP.');
                    }
                },
            ],
        ], [
            'nome.regex' => 'O nome deve conter apenas letras, espaços e hífen',
            'quantidade.min' => 'A quantidade deve ser maior que zero',
            'quantidade.max' => 'A quantidade máxima permitida é 1000',
            'preco.min' => 'O preço deve ser maior que zero',
            'preco.max' => 'O preço máximo permitido é R$ 1.000,00',
            'descricao.regex' => 'A descrição contém caracteres inválidos',
            'imagem.mimes' => 'A imagem deve ser nos formatos: JPG, JPEG, PNG ou WEBP',
            'imagem.max' => 'A imagem deve ter no máximo 4MB',
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
        // Prepara o preço para validação (converte vírgula para ponto)
        $preco = str_replace(',', '.', $request->input('preco'));
        $request->merge(['preco' => $preco]);

        $cardapio = Cardapio::findOrFail($id);
        $validatedData = $request->validate([
            'nome' => ['required', 'string', 'min:2', 'max:25', 'regex:/^[a-zA-ZÀ-ÿ\s-]+$/'],
            'quantidade' => ['required', 'integer', 'min:1', 'max:1000'],
            'validade' => ['nullable', 'date', 'after:today'],
            'preco' => ['required', 'numeric', 'min:0.01', 'max:1000', 'regex:/^\d+(\.\d{1,2})?$/'],
            'descricao' => ['required', 'string', 'min:5', 'max:125', 'regex:/^[a-zA-ZÀ-ÿ0-9\s.,!?-]+$/'],
            'imagem' => [
                'nullable',
                'file',
                'max:4096',
                'mimes:jpeg,jpg,png,webp',
                function ($attribute, $value, $fail) {
                    // Verifica o MIME type real do arquivo
                    $mimeType = $value->getMimeType();
                    $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                    
                    if (!in_array($mimeType, $allowedMimes)) {
                        $fail('O arquivo deve ser uma imagem nos formatos: JPG, JPEG, PNG ou WEBP.');
                    }
                },
            ],
        ], [
            'nome.regex' => 'O nome deve conter apenas letras, espaços e hífen',
            'quantidade.min' => 'A quantidade deve ser maior que zero',
            'quantidade.max' => 'A quantidade máxima permitida é 1000',
            'preco.min' => 'O preço deve ser maior que zero',
            'preco.max' => 'O preço máximo permitido é R$ 1.000,00',
            'descricao.regex' => 'A descrição contém caracteres inválidos',
            'imagem.mimes' => 'A imagem deve ser nos formatos: JPG, JPEG, PNG ou WEBP',
            'imagem.max' => 'A imagem deve ter no máximo 4MB',
        ]);

        // Se enviou uma nova imagem, faz upload e atualiza o campo
        if ($request->hasFile('imagem')) {
            // Apaga a imagem antiga do storage
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
