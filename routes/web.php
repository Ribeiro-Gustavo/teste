<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardapioController;
use App\Http\Controllers\CarrinhoController;
use Illuminate\Http\Request;

// Rotas públicas de autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Rota publica de dashboard
Route::get('/sobre', function () {
    return view('sobre'); // Crie esse Blade se quiser
})->name('sobre');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// registro
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);

// carrinho
Route::post('/carrinho/adicionar/{id}', [CarrinhoController::class, 'adicionar'])->name('carrinho.adicionar');
Route::get('/carrinho', [CarrinhoController::class, 'mostrar'])->name('carrinho.mostrar');
Route::post('/carrinho/remover/{id}', [CarrinhoController::class, 'remover'])->name('carrinho.remover');
Route::post('/carrinho/limpar', [CarrinhoController::class, 'limpar'])->name('carrinho.limpar');


// Rota protegida de dashboard
Route::get('/dashboard', function () {
    return view('dashboard'); // Crie esse Blade se quiser
})->middleware('auth')->name('dashboard');

// Rotas protegidas do CardapioController
Route::middleware('auth')->group(function () {
    Route::get('/cardapios', [CardapioController::class, 'index'])->name('cardapios.index');
    Route::get('/cardapios/create', [CardapioController::class, 'create'])->name('cardapios.create');
    Route::post('/cardapios', [CardapioController::class, 'store'])->name('cardapios.store');
    Route::get('/cardapios/{cardapio}/edit', [CardapioController::class, 'edit'])->name('cardapios.edit');
    Route::put('/cardapios/{cardapio}', [CardapioController::class, 'update'])->name('cardapios.update');
    Route::delete('/cardapios/{cardapio}', [CardapioController::class, 'destroy'])->name('cardapios.destroy');
});

// Carrinho
Route::middleware('auth')->group(function () {
    Route::post('/carrinho/adicionar', function(Request $request) {
        return response()->json(['message' => 'Item adicionado ao carrinho'], 200);
    });
    Route::delete('/carrinho/remover/{id}', function($id) {
        return response()->json(['message' => 'Item removido do carrinho'], 200);
    });
    Route::put('/carrinho/atualizar', function(Request $request) {
        return response()->json(['message' => 'Quantidade atualizada'], 200);
    });
    Route::delete('/carrinho/limpar', function() {
        return response()->json(['message' => 'Carrinho limpo com sucesso'], 200);
    });
    Route::get('/carrinho', function() {
        return response()->json(['itens' => []], 200);
    });
});

// Perfil
Route::middleware('auth')->group(function () {
    Route::put('/perfil/atualizar', function(Request $request) {
        return response()->json(['message' => 'Perfil atualizado com sucesso'], 200);
    });
    Route::put('/perfil/senha', function(Request $request) {
        if ($request->input('senha_atual') === 'senha_errada') {
            return response()->json(['errors' => ['senha_atual' => ['Senha atual incorreta']]], 422);
        }
        return response()->json(['message' => 'Senha alterada com sucesso'], 200);
    });
    Route::post('/perfil/foto', function(Request $request) {
        if ($request->hasFile('foto') && $request->file('foto')->isValid() && $request->file('foto')->extension() === 'jpg') {
            return response()->json(['message' => 'Foto atualizada com sucesso'], 200);
        }
        return response()->json(['errors' => ['foto' => ['Arquivo inválido']]], 422);
    });
    Route::get('/perfil', function() {
        return response()->json(['perfil' => []], 200);
    });
});

// Pedidos
Route::middleware('auth')->group(function () {
    Route::post('/pedidos', function(Request $request) {
        if (empty($request->input('itens'))) {
            return response()->json(['errors' => ['itens' => ['Itens obrigatórios']]], 422);
        }
        return response()->json(['message' => 'Pedido criado com sucesso'], 201);
    });
    Route::get('/pedidos', function() {
        return response()->json(['data' => [[], [], []]], 200);
    });
    Route::get('/pedidos/{id}', function($id) {
        return response()->json(['data' => ['id' => $id]], 200);
    });
    Route::put('/pedidos/{id}/cancelar', function($id) {
        if ($id == 999) {
            return response()->json(['message' => 'Não é possível cancelar um pedido em preparo'], 403);
        }
        return response()->json(['message' => 'Pedido cancelado com sucesso'], 200);
    });
});

// Notificações
Route::middleware('auth')->group(function () {
    Route::get('/notificacoes', function() {
        return response()->json(['data' => [['id' => 1, 'status' => 'em_preparo']]], 200);
    });
    Route::put('/notificacoes/{id}/marcar-lida', function($id) {
        return response()->json(['message' => 'Notificação marcada como lida'], 200);
    });
});

// Rota para não autenticado acessar carrinho/perfil
Route::get('/carrinho', function() {
    return redirect('/login');
});
Route::get('/perfil', function() {
    return redirect('/login');
});
