@extends('layouts.menuLateral')

@section('content')
<div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 min-h-screen">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-primary-600 to-primary-800 py-16">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">
                Sobre <span class="text-primary-200">Nós</span>
            </h1>
            <p class="text-xl text-primary-100 max-w-2xl mx-auto">
                Conheça a história por trás dos melhores hambúrgueres artesanais da cidade
            </p>
        </div>
    </div>

    <!-- Story Section -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-700">
            <div class="p-8 md:p-12">
                <div class="text-center mb-8">
                    <div class="w-24 h-24 bg-primary-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-hamburger text-3xl text-white"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-white mb-4">Gusta's Burguer</h2>
                </div>

                <div class="space-y-6 text-gray-300 leading-relaxed">
                    <p class="text-lg">
                        Tudo começou na cozinha de casa do Gustavo, um jovem empreendedor apaixonado por gastronomia e com um sonho: trazer hambúrgueres artesanais de alta qualidade feitos com amor e atenção aos detalhes.
                    </p>

                    <p class="text-lg">
                        Aqui, cada hambúrguer é preparado artesanalmente, com ingredientes frescos e selecionados, buscando sempre aquele sabor único que só a comida feita com cuidado pode proporcionar. Desde o pão até o molho, tudo é pensado para entregar a melhor experiência para nossos clientes.
                    </p>

                    <p class="text-lg">
                        Nosso compromisso é com a qualidade, o sabor e o carinho em cada etapa do processo. Mais do que uma hamburgueria, somos um lugar onde tradição e inovação se encontram para criar algo especial.
                    </p>
                </div>

                <!-- Values -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
                    <div class="text-center p-6 bg-gray-700 rounded-xl">
                        <i class="fas fa-star text-3xl text-primary-500 mb-4"></i>
                        <h3 class="text-xl font-semibold text-white mb-2">Qualidade</h3>
                        <p class="text-gray-400">Ingredientes selecionados e preparação artesanal</p>
                    </div>

                    <div class="text-center p-6 bg-gray-700 rounded-xl">
                        <i class="fas fa-heart text-3xl text-primary-500 mb-4"></i>
                        <h3 class="text-xl font-semibold text-white mb-2">Paixão</h3>
                        <p class="text-gray-400">Amor pela gastronomia em cada hambúrguer</p>
                    </div>

                    <div class="text-center p-6 bg-gray-700 rounded-xl">
                        <i class="fas fa-users text-3xl text-primary-500 mb-4"></i>
                        <h3 class="text-xl font-semibold text-white mb-2">Comunidade</h3>
                        <p class="text-gray-400">Criando momentos especiais para nossos clientes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Social Media Section -->
    <div class="bg-gray-800 py-16 border-t border-gray-700">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Conecte-se Conosco</h2>
            <p class="text-gray-400 mb-8 text-lg">
                Acompanhe nossas novidades, promoções e eventos nas redes sociais
            </p>

            <div class="flex justify-center space-x-6">
                <a href="https://www.instagram.com/seu_usuario_instagram"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="group bg-gradient-to-r from-purple-500 to-pink-500 p-4 rounded-full hover:scale-110 transition-transform duration-200">
                    <i class="fab fa-instagram text-2xl text-white"></i>
                </a>

                <a href="https://www.facebook.com/seu_usuario_facebook"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="group bg-blue-600 p-4 rounded-full hover:scale-110 transition-transform duration-200">
                    <i class="fab fa-facebook-f text-2xl text-white"></i>
                </a>

                <a href="https://wa.me/5511999999999"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="group bg-green-500 p-4 rounded-full hover:scale-110 transition-transform duration-200">
                    <i class="fab fa-whatsapp text-2xl text-white"></i>
                </a>
            </div>

            <div class="mt-8 p-6 bg-gray-700 rounded-xl inline-block">
                <h3 class="text-xl font-semibold text-white mb-2">Horário de Funcionamento</h3>
                <div class="text-gray-300 space-y-1">
                    <p>Segunda a Quinta: 18h às 23h</p>
                    <p>Sexta e Sábado: 18h às 00h</p>
                    <p>Domingo: 18h às 22h</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
