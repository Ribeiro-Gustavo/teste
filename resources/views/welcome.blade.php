<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

<body class="bg-gray-900 text-white">
    <!-- Header -->
    <header class="bg-gray-800 shadow-lg border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-primary-500">Gusta's Burguer</h1>
                </div>

                @if (Route::has('login'))
                    <nav class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 font-medium">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                                <i class="fas fa-sign-in-alt mr-2"></i>Entrar
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 font-medium">
                                    <i class="fas fa-user-plus mr-2"></i>Registrar
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <div
        class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-primary-900">
        <div class="absolute inset-0 bg-black opacity-50"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Logo/Icon -->
            <div class="mb-8">
                <div
                    class="w-24 h-24 bg-primary-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-2xl">
                    <i class="fas fa-hamburger text-3xl text-white"></i>
                </div>
            </div>

            <!-- Main Content -->
            <h1 class="text-5xl md:text-7xl font-bold mb-6">
                Gusta's
                <br>Burguer
            </h1>

            <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto">
                Hambúrgueres artesanais feitos com amor, ingredientes frescos e muito sabor.
                Uma experiência gastronômica única que começou na cozinha de casa.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                @auth
                    <a href="{{ route('cardapios.index') }}"
                        class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 px-8 rounded-lg text-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-utensils mr-2"></i>Ver Cardápio
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-gray-900 font-bold py-4 px-8 rounded-lg text-lg transition-all duration-200">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 px-8 rounded-lg text-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i>Entrar
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-gray-900 font-bold py-4 px-8 rounded-lg text-lg transition-all duration-200">
                        <i class="fas fa-user-plus mr-2"></i>Criar Conta
                    </a>
                @endauth
            </div>

            <!-- Features -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
                <div class="text-center">
                    <div class="bg-primary-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-leaf text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Ingredientes Frescos</h3>
                    <p class="text-gray-400">Selecionamos os melhores ingredientes para garantir qualidade e sabor
                        únicos.</p>
                </div>

                <div class="text-center">
                    <div class="bg-primary-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Feito com Amor</h3>
                    <p class="text-gray-400">Cada hambúrguer é preparado artesanalmente com muito carinho e atenção aos
                        detalhes.</p>
                </div>

                <div class="text-center">
                    <div class="bg-primary-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Entrega Rápida</h3>
                    <p class="text-gray-400">Preparamos seu pedido com agilidade para que você receba sempre fresquinho.
                    </p>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <i class="fas fa-chevron-down text-2xl text-primary-400"></i>
        </div>
    </div>

    <!-- About Section -->
    <div class="bg-gray-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-white mb-4">Nossa História</h2>
                <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                    Tudo começou na cozinha de casa do Gustavo, um jovem empreendedor apaixonado por gastronomia
                    e com um sonho: trazer hambúrgueres artesanais de alta qualidade feitos com amor e atenção aos
                    detalhes.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h3 class="text-2xl font-bold text-white mb-4">Qualidade em Cada Detalhe</h3>
                    <p class="text-gray-400 mb-6">
                        Aqui, cada hambúrguer é preparado artesanalmente, com ingredientes frescos e selecionados,
                        buscando sempre aquele sabor único que só a comida feita com cuidado pode proporcionar.
                    </p>
                    <p class="text-gray-400">
                        Nosso compromisso é com a qualidade, o sabor e o carinho em cada etapa do processo.
                        Mais do que uma hamburgueria, somos um lugar onde tradição e inovação se encontram para criar
                        algo especial.
                    </p>
                </div>

                <div class="bg-gray-700 rounded-xl p-8">
                    <h4 class="text-xl font-semibold text-white mb-4">Nossos Valores</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-300">
                            <i class="fas fa-check text-primary-500 mr-3"></i>
                            Ingredientes frescos e selecionados
                        </li>
                        <li class="flex items-center text-gray-300">
                            <i class="fas fa-check text-primary-500 mr-3"></i>
                            Preparação artesanal
                        </li>
                        <li class="flex items-center text-gray-300">
                            <i class="fas fa-check text-primary-500 mr-3"></i>
                            Atendimento personalizado
                        </li>
                        <li class="flex items-center text-gray-300">
                            <i class="fas fa-check text-primary-500 mr-3"></i>
                            Compromisso com a qualidade
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 py-8 border-t border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400">
                &copy; {{ date('Y') }} Gusta's Burguer. Todos os direitos reservados.
            </p>
        </div>
    </footer>
</body>

</html>
