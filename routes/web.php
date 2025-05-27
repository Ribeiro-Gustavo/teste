<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardapioController;
use App\Http\Controllers\CarrinhoController;

// Rotas públicas de autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Rota publica de dashboard
Route::get('/sobre', function () {
    return view('sobre'); // Crie esse Blade se quiser
})->name('sobre');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


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

// Rotas protegidas do CardapioController
Route::middleware('auth')->group(function () {
    Route::get('/cardapios', [CardapioController::class, 'index'])->name('cardapios.index');
    Route::get('/cardapios/create', [CardapioController::class, 'create'])->name('cardapios.create');
    Route::post('/cardapios', [CardapioController::class, 'store'])->name('cardapios.store');
    Route::get('/cardapios/{cardapio}/edit', [CardapioController::class, 'edit'])->name('cardapios.edit');
    Route::put('/cardapios/{cardapio}', [CardapioController::class, 'update'])->name('cardapios.update');
    Route::delete('/cardapios/{cardapio}', [CardapioController::class, 'destroy'])->name('cardapios.destroy');
});