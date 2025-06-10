<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <button onclick="toggleCarrinho()" class="relative focus:outline-none transition-colors duration-200" style="color:#bdbdbd;">
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
                        <button onclick="toggleCarrinho()" class="relative focus:outline-none transition-colors duration-200" style="color:#bdbdbd;">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            @php 
                                $carrinho = session()->get(Auth::check() ? 'carrinho_' . Auth::id() : 'carrinho_guest', []); 
                                $totalItens = array_sum(array_column($carrinho, 'quantidade'));
                            @endphp
                            @if($totalItens > 0)
                                <span class="absolute -top-2 -right-2 bg-primary-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ $totalItens }}
                                </span>
                            @endif
                        </button>
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
            @if(request()->route()->getName() !== 'home')
                <a href="{{ route('cardapios.index') }}" class="flex items-center px-4 py-3 hover:text-white transition-colors duration-200" style="color:#bdbdbd;">
                    <i class="fas fa-utensils mr-3"></i>Cardápio
                </a>
            @endif
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
                <button onclick="toggleCarrinho()" class="hover:text-white focus:outline-none" style="color:#757575;">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-4">
                @if(session('sucesso'))
                    <div class="bg-green-600 border border-green-500 text-white px-4 py-3 rounded-lg shadow-lg mb-4">
                        {{ session('sucesso') }}
                    </div>
                @endif

                @if(session('erro'))
                    <div class="bg-red-600 border border-red-500 text-white px-4 py-3 rounded-lg shadow-lg mb-4">
                        {{ session('erro') }}
                    </div>
                @endif

                @php 
                    $carrinho = session()->get(Auth::check() ? 'carrinho_' . Auth::id() : 'carrinho_guest', []); 
                @endphp

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
                                <form action="{{ route('carrinho.remover', $id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 ml-2">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach

                        <div class="border-t pt-4" style="border-color:#222222;">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-lg font-semibold text-white">Total:</span>
                                <span class="text-xl font-bold text-primary-500">R$ {{ number_format($total, 2, ',', '.') }}</span>
                            </div>

                            <form action="{{ route('pedidos.finalizar') }}" method="POST">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label for="nome_cliente" class="block text-sm font-medium text-gray-400 mb-1">Nome</label>
                                        <input type="text" name="nome_cliente" id="nome_cliente" required
                                            class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-primary-500"
                                            placeholder="Seu nome completo">
                                    </div>

                                    <div>
                                        <label for="telefone_cliente" class="block text-sm font-medium text-gray-400 mb-1">Telefone</label>
                                        <input type="text" name="telefone_cliente" id="telefone_cliente" required
                                            class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-primary-500"
                                            placeholder="(00) 00000-0000">
                                    </div>

                                    <div>
                                        <label for="endereco_entrega" class="block text-sm font-medium text-gray-400 mb-1">Endereço de Entrega</label>
                                        <input type="text" name="endereco_entrega" id="endereco_entrega" required
                                            class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-primary-500"
                                            placeholder="Rua, número, bairro, complemento">
                                    </div>

                                    <div>
                                        <label for="horario_entrega" class="block text-sm font-medium text-gray-400 mb-1">Horário de Entrega</label>
                                        <input type="time" name="horario_entrega" id="horario_entrega" required
                                            class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-primary-500">
                                    </div>

                                    <div>
                                        <label for="observacoes" class="block text-sm font-medium text-gray-400 mb-1">Observações</label>
                                        <textarea name="observacoes" id="observacoes" rows="2"
                                            class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-primary-500"
                                            placeholder="Instruções especiais para entrega"></textarea>
                                    </div>
                                </div>

                                <div class="flex space-x-2 mt-4">
                                    <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-lg transition-colors duration-200">
                                        <i class="fas fa-check mr-2"></i>Finalizar Pedido
                                    </button>
                                </div>
                            </form>
                        </div>
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

    <!-- Modal de Confirmação do Pedido -->
    <div id="confirmacaoPedidoModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-gray-800 rounded-lg shadow-xl max-w-lg w-full max-h-screen overflow-y-auto border" style="background-color:#181818; border:1px solid #222222;">
            <div class="flex items-center justify-between p-4 border-b" style="border-bottom:1px solid #222222;">
                <h3 class="text-lg font-semibold text-white">
                    <i class="fas fa-check-circle mr-2 text-green-500"></i>Pedido Confirmado!
                </h3>
                <button onclick="toggleConfirmacaoPedido()" class="hover:text-white focus:outline-none" style="color:#757575;">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-4">
                <div class="text-center mb-6">
                    <i class="fas fa-check-circle text-5xl text-green-500 mb-4"></i>
                    <p class="text-gray-400">Seu pedido foi recebido e está sendo processado.</p>
                </div>

                <div class="space-y-4">
                    <!-- Informações do Cliente -->
                    <div class="bg-gray-700 rounded-lg p-4">
                        <h2 class="text-lg font-semibold text-white mb-3">Informações do Cliente</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-400">Nome</p>
                                <p class="text-white" id="confirmacaoNome"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Telefone</p>
                                <p class="text-white" id="confirmacaoTelefone"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Itens do Pedido -->
                    <div class="bg-gray-700 rounded-lg p-4">
                        <h2 class="text-lg font-semibold text-white mb-3">Itens do Pedido</h2>
                        <div class="space-y-3" id="confirmacaoItens">
                            <!-- Itens serão inseridos aqui via JavaScript -->
                        </div>
                    </div>

                    <!-- Informações de Entrega -->
                    <div class="bg-gray-700 rounded-lg p-4">
                        <h2 class="text-lg font-semibold text-white mb-3">Informações de Entrega</h2>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-gray-400">Endereço</p>
                                <p class="text-white" id="confirmacaoEndereco"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Horário de Entrega</p>
                                <p class="text-white" id="confirmacaoHorario"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Tempo Médio de Entrega</p>
                                <p class="text-white">30-45 minutos</p>
                            </div>
                            <div id="confirmacaoObservacoes">
                                <!-- Observações serão inseridas aqui via JavaScript -->
                            </div>
                        </div>
                    </div>

                    <!-- Total do Pedido -->
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-white">Total do Pedido</span>
                            <span class="text-2xl font-bold text-primary-500" id="confirmacaoTotal"></span>
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex space-x-4">
                        <a href="{{ route('home') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white text-center py-3 px-4 rounded-lg transition-colors duration-200">
                            <i class="fas fa-home mr-2"></i>Voltar ao Início
                        </a>
                        @if(Auth::check())
                            <a href="{{ route('pedidos.index') }}" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white text-center py-3 px-4 rounded-lg transition-colors duration-200">
                                <i class="fas fa-list mr-2"></i>Meus Pedidos
                            </a>
                        @endif
                    </div>
                </div>
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

        function toggleCarrinho() {
            const modal = document.getElementById('carrinhoModal');
            if (modal) {
                modal.classList.toggle('hidden');
            }
        }

        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }

        function toggleConfirmacaoPedido() {
            const modal = document.getElementById('confirmacaoPedidoModal');
            if (modal) {
                modal.classList.toggle('hidden');
            }
        }

        // Fechar menus ao clicar fora
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('userMenu');
            const userButton = event.target.closest('[onclick="toggleUserMenu()"]');

            if (!userButton && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });

        // Função para mostrar a confirmação do pedido
        function mostrarConfirmacaoPedido(dados) {
            // Preencher os dados do pedido
            document.getElementById('confirmacaoNome').textContent = dados.nome_cliente;
            document.getElementById('confirmacaoTelefone').textContent = dados.telefone_cliente;
            document.getElementById('confirmacaoEndereco').textContent = dados.endereco_entrega;
            document.getElementById('confirmacaoHorario').textContent = dados.horario_entrega;
            document.getElementById('confirmacaoTotal').textContent = `R$ ${dados.total}`;

            // Preencher os itens do pedido
            const itensContainer = document.getElementById('confirmacaoItens');
            itensContainer.innerHTML = '';
            dados.itens.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.className = 'flex justify-between items-center';
                itemElement.innerHTML = `
                    <div>
                        <p class="text-white">${item.nome}</p>
                        <p class="text-sm text-gray-400">${item.quantidade}x - R$ ${item.preco_unitario}</p>
                    </div>
                    <p class="text-white font-semibold">R$ ${item.subtotal}</p>
                `;
                itensContainer.appendChild(itemElement);
            });

            // Preencher observações se houver
            const observacoesContainer = document.getElementById('confirmacaoObservacoes');
            if (dados.observacoes) {
                observacoesContainer.innerHTML = `
                    <div>
                        <p class="text-sm text-gray-400">Observações</p>
                        <p class="text-white">${dados.observacoes}</p>
                    </div>
                `;
            } else {
                observacoesContainer.innerHTML = '';
            }

            // Mostrar o modal
            toggleConfirmacaoPedido();
        }

        // Máscara para telefone
        document.addEventListener('DOMContentLoaded', function() {
            const telefoneInput = document.getElementById('telefone_cliente');
            if (telefoneInput) {
                telefoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 11) value = value.slice(0, 11);
                    
                    if (value.length > 2) {
                        value = `(${value.slice(0, 2)}) ${value.slice(2)}`;
                    }
                    if (value.length > 9) {
                        value = `${value.slice(0, 9)}-${value.slice(9)}`;
                    }
                    
                    e.target.value = value;
                });
            }

            // Adicionar evento de submit ao formulário do carrinho
            const formCarrinho = document.querySelector('form[action="{{ route("pedidos.finalizar") }}"]');
            if (formCarrinho) {
                formCarrinho.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const data = {};
                    formData.forEach((value, key) => data[key] = value);

                    fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Fechar o modal do carrinho
                            toggleCarrinho();
                            // Mostrar o modal de confirmação
                            mostrarConfirmacaoPedido(data.pedido);
                        } else {
                            alert(data.error || 'Erro ao finalizar pedido');
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        alert('Erro ao finalizar pedido. Por favor, tente novamente.');
                    });
                });
            }

            // Adicionar evento de clique para fechar o modal ao clicar fora
            document.addEventListener('click', function(e) {
                const carrinhoModal = document.getElementById('carrinhoModal');
                const confirmacaoModal = document.getElementById('confirmacaoPedidoModal');
                
                if (carrinhoModal && !carrinhoModal.contains(e.target) && !e.target.closest('[onclick="toggleCarrinho()"]')) {
                    carrinhoModal.classList.add('hidden');
                }
                
                if (confirmacaoModal && !confirmacaoModal.contains(e.target) && !e.target.closest('[onclick="toggleConfirmacaoPedido()"]')) {
                    confirmacaoModal.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
