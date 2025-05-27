<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cardapio;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        $cardapios = Cardapio::all();
        return view('home', compact('cardapios'));
    }
}
