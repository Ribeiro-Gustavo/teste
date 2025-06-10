@extends('layouts.menuLateral')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, #111111 0%, #181818 50%, #111111 100%);">
    <!-- Hero Section -->
    <div class="relative py-16" style="background: linear-gradient(90deg, #f97316 0%, #c2410c 100%);">
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
        <div class="rounded-2xl shadow-2xl overflow-hidden border" style="background-color:#181818; border:1px solid #222222;">
            <div class="p-8 md:p-12">
                <div class="text-center mb-8">
                    <img src="{{ asset('images/gusta_logo.png') }}" alt="Gusta's Burguer Logo" class="h-24 w-auto mx-auto mb-4 object-contain">
                    <h2 class="text-3xl font-bold text-white mb-4">Gusta's Burguer</h2>
                </div>

                <div class="space-y-6 leading-relaxed" style="color:#bdbdbd;">
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
                    <div class="text-center p-6 rounded-xl" style="background-color:#222222;">
                        <i class="fas fa-star text-3xl text-primary-500 mb-4"></i>
                        <h3 class="text-xl font-semibold text-white mb-2">Qualidade</h3>
                        <p style="color:#bdbdbd;">Ingredientes selecionados e preparação artesanal</p>
                    </div>

                    <div class="text-center p-6 rounded-xl" style="background-color:#222222;">
                        <i class="fas fa-heart text-3xl text-primary-500 mb-4"></i>
                        <h3 class="text-xl font-semibold text-white mb-2">Paixão</h3>
                        <p style="color:#bdbdbd;">Amor pela gastronomia em cada hambúrguer</p>
                    </div>

                    <div class="text-center p-6 rounded-xl" style="background-color:#222222;">
                        <i class="fas fa-users text-3xl text-primary-500 mb-4"></i>
                        <h3 class="text-xl font-semibold text-white mb-2">Comunidade</h3>
                        <p style="color:#bdbdbd;">Criando momentos especiais para nossos clientes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Social Media Section -->
    <div class="py-16 border-t border-gray-700" style="background-color:#181818;">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Conecte-se Conosco</h2>
            <p class="text-gray-400 mb-8 text-lg">
                Acompanhe nossas novidades, promoções e eventos nas redes sociais
            </p>

            <div class="flex justify-center space-x-6">
                <a href="https://www.instagram.com/seu_usuario_instagram"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="group p-4 rounded-full hover:scale-110 transition-transform duration-200 bg-primary-600 group-hover:bg-primary-700">
                    <i class="fab fa-instagram text-2xl text-white"></i>
                </a>

                <a href="https://www.facebook.com/seu_usuario_facebook"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="group p-4 rounded-full hover:scale-110 transition-transform duration-200 bg-primary-600 group-hover:bg-primary-700">
                    <i class="fab fa-facebook-f text-2xl text-white"></i>
                </a>

                <a href="https://wa.me/5511999999999"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="group p-4 rounded-full hover:scale-110 transition-transform duration-200 bg-primary-600 group-hover:bg-primary-700">
                    <i class="fab fa-whatsapp text-2xl text-white"></i>
                </a>
            </div>

            <div class="mt-8 p-6 rounded-xl inline-block" style="background-color:#222222;">
                <h3 class="text-xl font-semibold text-white mb-2">Horário de Funcionamento</h3>
                <div class="space-y-1" style="color:#bdbdbd;">
                    <p>Segunda a Quinta: 18h às 23h</p>
                    <p>Sexta e Sábado: 18h às 00h</p>
                    <p>Domingo: 18h às 22h</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
