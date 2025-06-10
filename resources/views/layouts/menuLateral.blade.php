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
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="min-h-screen font-sans" style="background-color:#111111; color:#e5e5e5;">
    <!-- Header -->
    <header class="shadow-lg border-b" style="background-color:#181818; border-bottom:1px solid #222222;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                @auth
                    <div class="flex items-center space-x-4">
                        <button onclick="toggleSidebar()" style="color:#bdbdbd;" class="hover:text-white focus:outline-none focus:text-white transition-colors duration-200">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/gusta_logo.png') }}" alt="Gusta's Burguer Logo" class="h-10 w-auto object-contain">
                        </a>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Carrinho -->
                        <button onclick="toggleCarrinhoModal()" class="relative focus:outline-none transition-colors duration-200" style="color:#bdbdbd;">
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
                            <button onclick="toggleUserMenu()" class="flex items-center space-x-2 focus:outline-none transition-colors duration-200" style="color:#bdbdbd;">
                                <i class="fas fa-user-circle text-xl"></i>
                                <span class="hidden md:block">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>

                            <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 z-50 border" style="background-color:#181818; border:1px solid #222222;">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm hover:text-white transition-colors duration-200" style="color:#bdbdbd;">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                </a>
                                <form action="{{ route('logout') }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:text-white transition-colors duration-200" style="color:#bdbdbd;">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth

                @guest
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/gusta_logo.png') }}" alt="Gusta's Burguer Logo" class="h-10 w-auto object-contain">
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                            <i class="fas fa-sign-in-alt mr-2"></i>Entrar
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 transform -translate-x-full transition-transform duration-300 ease-in-out border-r" style="background-color:#181818; border-right:1px solid #222222;">
        <div class="flex items-center justify-between h-16 px-4 border-b" style="border-bottom:1px solid #222222;">
            <h2 class="text-lg font-semibold text-white">Menu</h2>
            <button onclick="toggleSidebar()" class="hover:text-white focus:outline-none" style="color:#757575;">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <nav class="mt-4">
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 hover:text-white transition-colors duration-200" style="color:#bdbdbd;">
                <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
            </a>
            <a href="{{ route('cardapios.index') }}" class="flex items-center px-4 py-3 hover:text-white transition-colors duration-200" style="color:#bdbdbd;">
                <i class="fas fa-utensils mr-3"></i>Cardápio
            </a>
            <a href="{{ route('sobre') }}" class="flex items-center px-4 py-3 hover:text-white transition-colors duration-200" style="color:#bdbdbd;">
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
    <div id="carrinhoModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-end p-4">
        <div class="rounded-lg shadow-xl max-w-lg w-full max-h-screen overflow-y-auto border" style="background-color:#181818; border:1px solid #222222;">
            <div class="flex items-center justify-between p-4 border-b" style="border-bottom:1px solid #222222;">
                <h3 class="text-lg font-semibold text-white">
                    <i class="fas fa-shopping-cart mr-2 text-primary-500"></i>Carrinho
                </h3>
                <button onclick="toggleCarrinhoModal()" class="hover:text-white focus:outline-none" style="color:#757575;">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-4">
                <!-- Mensagens de Erro de Validação -->
                @if ($errors->any())
                    <div class="bg-red-600 border border-red-500 text-white px-4 py-3 rounded-lg shadow-lg mb-4">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle mr-2 mt-0.5"></i>
                            <div>
                                <ul class="list-disc list-inside text-sm space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @php $carrinho = session('carrinho', []); @endphp

                @if(count($carrinho) > 0)
                    <div class="space-y-3">
                        @php $total = 0; @endphp
                        @foreach($carrinho as $id => $item)
                            @php
                                $subtotal = $item['preco'] * $item['quantidade'];
                                $total += $subtotal;
                            @endphp
                            <div class="flex items-center justify-between p-3 rounded-lg" style="background-color:#222222;">
                                <div class="flex-1">
                                    <h4 class="font-medium text-white">{{ $item['nome'] }}</h4>
                                    <p class="text-sm" style="color:#bdbdbd;">{{ $item['quantidade'] }}x - R$ {{ number_format($subtotal, 2, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('carrinho.remover', $id) }}" class="text-red-400 hover:text-red-300 ml-2">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-4 border-t" style="border-top:1px solid #222222;">
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-semibold text-white">Total:</span>
                            <span class="font-bold text-primary-500 text-lg">R$ {{ number_format($total, 2, ',', '.') }}</span>
                        </div>

                        <form action="{{ route('pedidos.finalizar') }}" method="POST" class="space-y-4">
                            @csrf

                            <!-- Nome do Cliente -->
                            <div>
                                <label for="nome_cliente" class="block text-sm font-medium text-gray-300 mb-1">Nome:</label>
                                <input type="text" name="nome_cliente" id="nome_cliente" value="{{ old('nome_cliente', auth()->user()->name) }}" required
                                       class="w-full px-3 py-2 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                       style="background-color:#222222; border:1px solid #333333;">
                            </div>

                            <!-- Telefone do Cliente -->
                            <div>
                                <label for="telefone_cliente" class="block text-sm font-medium text-gray-300 mb-1">Telefone:</label>
                                <input type="text" name="telefone_cliente" id="telefone_cliente" value="{{ old('telefone_cliente', auth()->user()->telefone) }}" required
                                       class="w-full px-3 py-2 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                       style="background-color:#222222; border:1px solid #333333;"
                                       placeholder="(DD) XXXXX-XXXX">
                            </div>

                            <!-- Endereço de Entrega -->
                            <div>
                                <label for="endereco_entrega" class="block text-sm font-medium text-gray-300 mb-1">Endereço de Entrega:</label>
                                <input type="text" name="endereco_entrega" id="endereco_entrega" value="{{ old('endereco_entrega') }}" required
                                       class="w-full px-3 py-2 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                       style="background-color:#222222; border:1px solid #333333;"
                                       placeholder="Rua, Número, Bairro, Cidade-UF">
                            </div>

                            <!-- Horário de Entrega -->
                            <div>
                                <label for="horario_entrega" class="block text-sm font-medium text-gray-300 mb-1">Horário de Entrega:</label>
                                <input type="text" name="horario_entrega" id="horario_entrega" value="{{ old('horario_entrega') }}" required
                                       class="w-full px-3 py-2 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                       style="background-color:#222222; border:1px solid #333333;"
                                       placeholder="Ex: 19:00 - 20:00">
                            </div>

                            <!-- Observações (Opcional) -->
                            <div>
                                <label for="observacoes" class="block text-sm font-medium text-gray-300 mb-1">Observações (opcional):</label>
                                <textarea name="observacoes" id="observacoes" rows="2"
                                          class="w-full px-3 py-2 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 resize-none"
                                          style="background-color:#222222; border:1px solid #333333;"
                                          placeholder="Ex: Sem cebola, entregar no vizinho.">{{ old('observacoes') }}</textarea>
                            </div>

                            <div class="flex space-x-2">
                                <a href="{{ route('carrinho.limpar') }}" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg text-center transition-colors duration-200">
                                    <i class="fas fa-trash mr-2"></i>Limpar
                                </a>
                                <button type="submit" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-lg transition-colors duration-200">
                                    <i class="fas fa-check mr-2"></i>Finalizar Pedido
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-shopping-cart text-4xl mb-4" style="color:#757575;"></i>
                        <p style="color:#bdbdbd;">Carrinho vazio</p>
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
