<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cardapio;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProdutos = Cardapio::count();
        $totalUsuarios = User::count();
        $itensCarrinho = array_sum(array_column(session('carrinho', []), 'quantidade'));

        return view('dashboard', compact('totalProdutos', 'totalUsuarios', 'itensCarrinho'));
    }
}
