<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlimentoController;
use App\Http\Controllers\CarrinhoController;

// Rotas públicas de autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// registro
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
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

// Rotas protegidas do AlimentoController
Route::middleware('auth')->group(function () {
    Route::get('/alimentos', [AlimentoController::class, 'index'])->name('alimentos.index');
    Route::get('/alimentos/create', [AlimentoController::class, 'create'])->name('alimentos.create');
    Route::post('/alimentos', [AlimentoController::class, 'store'])->name('alimentos.store');
    Route::get('/alimentos/{alimento}/edit', [AlimentoController::class, 'edit'])->name('alimentos.edit');
    Route::put('/alimentos/{alimento}', [AlimentoController::class, 'update'])->name('alimentos.update');
    Route::delete('/alimentos/{alimento}', [AlimentoController::class, 'destroy'])->name('alimentos.destroy');
});

// Página inicial redireciona pro login
Route::get('/', function () {
    return redirect()->route('login');
});
