<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gusta's Burguer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-gray-800 shadow-lg border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                @auth
                    <div class="flex items-center space-x-4">
                        <button onclick="toggleSidebar()" class="text-gray-300 hover:text-white focus:outline-none focus:text-white transition-colors duration-200">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-xl font-bold text-primary-500">Gusta's Burguer</h1>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Carrinho -->
                        <button onclick="toggleCarrinhoModal()" class="relative text-gray-300 hover:text-primary-500 focus:outline-none transition-colors duration-200">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            @php
                                $carrinho = session('carrinho', []);
                                $totalItens = array_sum(array_column($carrinho, 'quantidade'));
                            @endphp
                            @if($totalItens > 0)
                                <span class="absolute -top-2 -right-2 bg-primary-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ $totalItens }}
                                </span>
                            @endif
                        </button>

                        <!-- User Menu -->
                        <div class="relative">
                            <button onclick="toggleUserMenu()" class="flex items-center space-x-2 text-gray-300 hover:text-white focus:outline-none transition-colors duration-200">
                                <i class="fas fa-user-circle text-xl"></i>
                                <span class="hidden md:block">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>

                            <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-700">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                </a>
                                <form action="{{ route('logout') }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth

                @guest
                    <div class="flex items-center space-x-4">
                        <h1 class="text-xl font-bold text-primary-500">Gusta's Burguer</h1>
                    </div>
                @endguest
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-800 transform -translate-x-full transition-transform duration-300 ease-in-out border-r border-gray-700">
        <div class="flex items-center justify-between h-16 px-4 border-b border-gray-700">
            <h2 class="text-lg font-semibold text-white">Menu</h2>
            <button onclick="toggleSidebar()" class="text-gray-400 hover:text-white focus:outline-none">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <nav class="mt-4">
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
                <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
            </a>
            <a href="{{ route('cardapios.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
                <i class="fas fa-utensils mr-3"></i>Cardápio
            </a>
            <a href="{{ route('sobre') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
                <i class="fas fa-info-circle mr-3"></i>Sobre
            </a>
        </nav>
    </div>

    <!-- Overlay -->
    <div id="sidebarOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40" onclick="toggleSidebar()"></div>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Modal do Carrinho -->
    <div id="carrinhoModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-gray-800 rounded-lg shadow-xl max-w-md w-full max-h-96 overflow-hidden border border-gray-700">
            <div class="flex items-center justify-between p-4 border-b border-gray-700">
                <h3 class="text-lg font-semibold text-white">
                    <i class="fas fa-shopping-cart mr-2 text-primary-500"></i>Carrinho
                </h3>
                <button onclick="toggleCarrinhoModal()" class="text-gray-400 hover:text-white focus:outline-none">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-4 overflow-y-auto max-h-64">
                @php $carrinho = session('carrinho', []); @endphp

                @if(count($carrinho) > 0)
                    <div class="space-y-3">
                        @php $total = 0; @endphp
                        @foreach($carrinho as $id => $item)
                            @php
                                $subtotal = $item['preco'] * $item['quantidade'];
                                $total += $subtotal;
                            @endphp
                            <div class="flex items-center justify-between bg-gray-700 p-3 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-white">{{ $item['nome'] }}</h4>
                                    <p class="text-sm text-gray-400">{{ $item['quantidade'] }}x - R$ {{ number_format($subtotal, 2, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('carrinho.remover', $id) }}" class="text-red-400 hover:text-red-300 ml-2">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-700">
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-semibold text-white">Total:</span>
                            <span class="font-bold text-primary-500 text-lg">R$ {{ number_format($total, 2, ',', '.') }}</span>
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('carrinho.limpar') }}" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg text-center transition-colors duration-200">
                                <i class="fas fa-trash mr-2"></i>Limpar
                            </a>
                            <button onclick="finalizarPedido()" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-lg transition-colors duration-200">
                                <i class="fas fa-check mr-2"></i>Finalizar
                            </button>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-shopping-cart text-4xl text-gray-600 mb-4"></i>
                        <p class="text-gray-400">Carrinho vazio</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function toggleCarrinhoModal() {
            const modal = document.getElementById('carrinhoModal');
            modal.classList.toggle('hidden');
        }

        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }

        function finalizarPedido() {
            alert('Funcionalidade de finalização de pedido será implementada em breve!');
        }

        // Fechar menus ao clicar fora
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('userMenu');
            const userButton = event.target.closest('[onclick="toggleUserMenu()"]');

            if (!userButton && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
