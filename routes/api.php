<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PerfilController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rotas de Carrinho (API) - COMENTADAS PARA VOLTAR PARA WEB.PHP
// Route::middleware('auth')->group(function () {
//     Route::post('/carrinho/adicionar', [CarrinhoController::class, 'adicionar']);
//     Route::delete('/carrinho/remover/{id}', [CarrinhoController::class, 'remover']);
//     Route::delete('/carrinho/limpar', [CarrinhoController::class, 'limpar']);
// });

// Rotas de Pedidos (API) - COMENTADAS PARA VOLTAR PARA WEB.PHP
// Route::middleware('auth')->group(function () {
//     Route::post('/pedidos/finalizar', [PedidoController::class, 'processOrder'])->name('pedidos.finalizar');
//     Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
//     Route::get('/pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show');
//     Route::put('/pedidos/{pedido}/cancelar', [PedidoController::class, 'cancel'])->name('pedidos.cancelar');
// });

// Rotas de Perfil (API) - COMENTADAS PARA VOLTAR PARA WEB.PHP
// Route::middleware('auth')->group(function () {
//     Route::put('/perfil/atualizar', function(Request $request) {
//         return response()->json(['message' => 'Perfil atualizado com sucesso'], 200);
//     });
//     Route::put('/perfil/senha', function(Request $request) {
//         if ($request->input('senha_atual') === 'senha_errada') {
//             return response()->json(['errors' => ['senha_atual' => ['Senha atual incorreta']]], 422);
//         }
//         return response()->json(['message' => 'Senha alterada com sucesso'], 200);
//     });
//     Route::post('/perfil/foto', function(Request $request) {
//         if ($request->hasFile('foto') && $request->file('foto')->isValid() && $request->file('foto')->extension() === 'jpg') {
//             return response()->json(['message' => 'Foto atualizada com sucesso'], 200);
//         }
//         return response()->json(['errors' => ['foto' => ['Arquivo inválido']]], 422);
//     });
//     Route::get('/perfil', function() {
//         return response()->json(['perfil' => []], 200);
//     });
// });
