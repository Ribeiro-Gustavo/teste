<!DOCTYPE html>
<html>
<head>
    <title>MinhaApp</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #f5f5f5;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
        }

        .left-header {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .right-header {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .menu-button {
            font-size: 24px;
            cursor: pointer;
            background: none;
            border: none;
        }

        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #333;
            overflow-x: hidden;
            transition: 0.3s;
            padding-top: 60px;
            z-index: 1000;
        }

        .sidebar a {
            padding: 12px 24px;
            text-decoration: none;
            font-size: 18px;
            color: #f1f1f1;
            display: block;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .logout-form button {
            background: none;
            border: none;
            color: #333;
            font-size: 16px;
            cursor: pointer;
        }

        /* Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            width: 400px;
            border-radius: 8px;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
        }

        .modal-close {
            cursor: pointer;
            font-size: 20px;
        }

        .carrinho-button {
            font-size: 20px;
            cursor: pointer;
            background: none;
            border: none;
        }
    </style>
</head>
<body>

<header>
    @auth
        <div class="left-header">
            <button class="menu-button" onclick="toggleSidebar()">☰</button>
        </div>

        <div class="right-header">
            <!-- Botão do carrinho -->
            <button class="carrinho-button" onclick="toggleCarrinhoModal()">🛒</button>

            <!-- Botão de logout -->
            <form class="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Sair</button>
            </form>
        </div>
    @endauth

    @guest
        <div class="right-header" style="text-align: right; padding: 10px;">
            <a href="{{ route('login') }}" style="text-decoration: none; background: #333; color: white; padding: 8px 12px; border-radius: 5px;">
                Login
            </a>
        </div>
    @endguest
</header>


<!-- Menu lateral -->
<div id="sidebar" class="sidebar">
    <a href="javascript:void(0)" onclick="toggleSidebar()">✕ Fechar</a>
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <a href="{{ route('cardapios.index') }}">Cardapios</a>
    <a href="{{ route('sobre') }}">Sobre</a>
    <!-- Adicione mais páginas aqui -->
</div>

<!-- Modal do carrinho -->
<div id="carrinhoModal" style="display: none; position: fixed; right: 10px; top: 60px; background: white; border: 1px solid #ccc; padding: 20px; z-index: 1000;">
    <h2>Itens no Carrinho</h2>

    @php
        $carrinho = session('carrinho', []);
    @endphp

    @if (count($carrinho) > 0)
        <ul>
            @foreach ($carrinho as $id => $item)
                <li style="margin-bottom: 10px;">
                    <strong>{{ $item['nome'] }}</strong><br>
                    Validade: {{ $item['validade'] ?? 'Sem validade' }}<br>
                    Quantidade: {{ $item['quantidade'] }}

                    <!-- Botão para remover item -->
                    <a href="{{ route('carrinho.remover', $id) }}" style="color: red; margin-left: 10px;">X</a>
                </li>
            @endforeach
        </ul>

        <div style="margin-top: 15px;">
            <a href="{{ route('carrinho.limpar') }}" style="background: red; color: white; padding: 5px 10px; margin-right: 10px;">Limpar Carrinho</a>
            <button onclick="document.getElementById('carrinhoModal').style.display='none'">Fechar</button>
        </div>
    @else
        <p>Carrinho vazio.</p>
        <button onclick="document.getElementById('carrinhoModal').style.display='none'">Fechar</button>
    @endif
</div>

<main style="padding: 1rem;">
    @yield('content')
</main>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.style.width = sidebar.style.width === '250px' ? '0' : '250px';
    }

    function toggleCarrinhoModal() {
        const modal = document.getElementById('carrinhoModal');
        modal.style.display = modal.style.display === 'block' ? 'none' : 'block';
    }
</script>

</body>
</html>
