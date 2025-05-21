<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alimento;

class AlimentoController extends Controller
{
public function index()
{
    $alimentos = Alimento::all();
    $carrinho = session()->get('carrinho', []);
    return view('alimentos.index', compact('alimentos', 'carrinho'));
}

public function create()
{
return view('alimentos.create');
}

public function store(Request $request)
{
$request->validate([

'nome' => 'required',
'quantidade' => 'required|integer',
'validade' => 'nullable|date',
]);

Alimento::create($request->all());

return redirect()->route('alimentos.index')->with('sucesso', 'Alimento adicionado!');
}

public function edit(Alimento $alimento)
{
return view('alimentos.edit', compact('alimento'));
}

public function update(Request $request, Alimento $alimento)
{
$request->validate([
'nome' => 'required',
'quantidade' => 'required|integer',
'validade' => 'nullable|date',
]);

$alimento->update($request->all());

return redirect()->route('alimentos.index')->with('sucesso', 'Alimento atualizado!');
}

public function destroy(Alimento $alimento)
{
$alimento->delete();

return redirect()->route('alimentos.index')->with('sucesso', 'Alimento removido!');
}
}