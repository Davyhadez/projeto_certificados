<!DOCTYPE html>
<html lang="pt-BR" class="h-full bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Certificados - DETRAN-PA')</title>

    <!-- Tailwind CSS (Vite compilation) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap CSS e JS (mantidos temporariamente para compatibilidade com componentes legados) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap Icons (para suporte aos ícones clássicos) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- jQuery & Select2 (essenciais para formulários existentes) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Estilo adicional para compatibilidade suave de Bootstrap + Tailwind -->
    <style>
        /* Correção de reset de botões e links que conflitam */
        .btn-teal, .btn-teal-voltar, .btn-green-salvar, .btn-red-limpar {
            text-decoration: none !important;
        }
        /* Garante que o contorno de foco do Tailwind apareça sobre o reset do Bootstrap */
        *:focus-visible {
            outline: 3px solid #0d9488 !important;
            outline-offset: 2px !important;
        }
    </style>
</head>

<body class="h-full font-sans text-slate-800 antialiased flex flex-col">

    <!-- LINK DE ACESSIBILIDADE RÁPIDA (Para leitores de tela e usuários de teclado) -->
    <a href="#conteudo-principal" 
       class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-3 focus:bg-teal-700 focus:text-white focus:font-bold focus:rounded-lg focus:shadow-lg focus:ring-4 focus:ring-teal-500">
        Pular para o conteúdo principal
    </a>

    <div class="flex h-full min-h-screen overflow-hidden">
        
        <!-- SIDEBAR PARA DESKTOP (Telas md e maiores) -->
        <aside class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0 bg-teal-900 text-white shadow-xl z-20" aria-label="Menu Principal Lateral">
            <!-- Cabeçalho da Sidebar -->
            <div class="flex items-center gap-3 p-6 bg-teal-950 border-b border-teal-800">
                <img src="{{ asset('img/Logodetran_icon.webp') }}"
                     alt="Logotipo oficial do DETRAN-PA"
                     class="h-10 w-auto">
                <div class="flex flex-col">
                    <span class="font-bold text-sm leading-tight">DETRAN-PA</span>
                    <span class="text-xs text-teal-300">Certificados</span>
                </div>
            </div>

            <!-- Navegação Principal -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto" aria-label="Navegação Lateral">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition duration-150 group {{ request()->routeIs('dashboard') ? 'bg-teal-800 text-white shadow' : 'text-teal-100 hover:bg-teal-800/50 hover:text-white' }} focus:outline-none focus:ring-2 focus:ring-teal-400"
                   aria-current="{{ request()->routeIs('dashboard') ? 'page' : 'false' }}">
                    <i class="bi bi-house-door text-lg" aria-hidden="true"></i>
                    <span>Início / Painel</span>
                </a>

                <a href="{{ route('usuarios.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition duration-150 group {{ request()->routeIs('usuarios.index') ? 'bg-teal-800 text-white shadow' : 'text-teal-100 hover:bg-teal-800/50 hover:text-white' }} focus:outline-none focus:ring-2 focus:ring-teal-400"
                   aria-current="{{ request()->routeIs('usuarios.index') ? 'page' : 'false' }}">
                    <i class="bi bi-person text-lg" aria-hidden="true"></i>
                    <span>Usuários</span>
                </a>

                <a href="{{ route('pessoas.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition duration-150 group {{ request()->routeIs('pessoas.index') ? 'bg-teal-800 text-white shadow' : 'text-teal-100 hover:bg-teal-800/50 hover:text-white' }} focus:outline-none focus:ring-2 focus:ring-teal-400"
                   aria-current="{{ request()->routeIs('pessoas.index') ? 'page' : 'false' }}">
                    <i class="bi bi-people text-lg" aria-hidden="true"></i>
                    <span>Pessoas</span>
                </a>

                <a href="{{ route('eventos.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition duration-150 group {{ request()->routeIs('eventos.index') ? 'bg-teal-800 text-white shadow' : 'text-teal-100 hover:bg-teal-800/50 hover:text-white' }} focus:outline-none focus:ring-2 focus:ring-teal-400"
                   aria-current="{{ request()->routeIs('eventos.index') ? 'page' : 'false' }}">
                    <i class="bi bi-calendar-event text-lg" aria-hidden="true"></i>
                    <span>Eventos</span>
                </a>

                <a href="{{ route('turmas.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition duration-150 group {{ request()->routeIs('turmas.index') ? 'bg-teal-800 text-white shadow' : 'text-teal-100 hover:bg-teal-800/50 hover:text-white' }} focus:outline-none focus:ring-2 focus:ring-teal-400"
                   aria-current="{{ request()->routeIs('turmas.index') ? 'page' : 'false' }}">
                    <i class="bi bi-mortarboard text-lg" aria-hidden="true"></i>
                    <span>Turmas</span>
                </a>

                <a href="{{ route('assinatura.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition duration-150 group {{ request()->routeIs('assinatura.index') ? 'bg-teal-800 text-white shadow' : 'text-teal-100 hover:bg-teal-800/50 hover:text-white' }} focus:outline-none focus:ring-2 focus:ring-teal-400"
                   aria-current="{{ request()->routeIs('assinatura.index') ? 'page' : 'false' }}">
                    <i class="bi bi-file-earmark-text text-lg" aria-hidden="true"></i>
                    <span>Assinaturas</span>
                </a>
            </nav>

            <!-- Rodapé da Sidebar (Logout) -->
            <div class="p-4 border-t border-teal-800 bg-teal-950/50">
                <button type="button" 
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold text-red-200 hover:bg-red-900/40 hover:text-white transition duration-150 focus:outline-none focus:ring-2 focus:ring-red-400"
                        data-bs-toggle="modal"
                        data-bs-target="#logoutModal">
                    <i class="bi bi-box-arrow-right text-lg" aria-hidden="true"></i>
                    <span>Sair do Sistema</span>
                </button>
            </div>
        </aside>

        <!-- CONTEÚDO PRINCIPAL E HEADER -->
        <div class="flex-1 flex flex-col md:pl-64 w-full">
            
            <!-- HEADER (Navbar Superior) -->
            <header class="bg-white border-b border-slate-200 shadow-sm h-16 flex items-center justify-between px-4 md:px-8 z-10">
                
                <!-- Nome / Voltar -->
                <div class="flex items-center gap-4">
                    <!-- Botão de Voltar específico da view, se houver -->
                    @if(View::hasSection('voltarPessoas'))
                        <div class="inline-flex items-center">
                            @yield('voltarPessoas')
                        </div>
                    @else
                        <!-- Título geral ou logo secundário móvel -->
                        <div class="flex md:hidden items-center gap-2">
                            <img src="{{ asset('img/Logodetran_icon.webp') }}" alt="" class="h-8 w-auto">
                            <span class="font-bold text-teal-800 text-sm">DETRAN-PA</span>
                        </div>
                    @endif
                </div>

                <!-- Info Usuário Logado -->
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-100 border border-slate-200" aria-label="Identificação do usuário">
                        <i class="bi bi-person-circle text-teal-700 text-lg" aria-hidden="true"></i>
                        <span class="text-xs md:text-sm font-bold text-slate-700 uppercase tracking-wide">
                            {{ Auth::user()->login_usuario ?? 'Visitante' }}
                        </span>
                    </div>
                </div>
            </header>

            <!-- MAIN CONTAINER -->
            <main id="conteudo-principal" class="flex-1 overflow-y-auto p-4 md:p-8 pb-24 md:pb-8 focus:outline-none" tabindex="-1">
                @if(View::hasSection('conteudo'))
                    @yield('conteudo')
                @else
                    <!-- Boas-vindas Padrão (Semântico e Acessível) -->
                    <div class="max-w-4xl mx-auto bg-white rounded-2xl border border-slate-100 shadow-md p-8 md:p-12 text-center mt-4">
                        <h1 class="text-2xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                            Seja bem-vindo ao sistema de certificados!
                        </h1>
                        <p class="text-slate-500 text-base md:text-lg max-w-xl mx-auto mb-8">
                            Utilize o menu lateral (ou barra inferior em seu celular) para gerenciar usuários, pessoas, eventos e turmas de forma simples e rápida.
                        </p>
                        <div class="flex justify-center">
                            <img src="https://www.motoragora.com.br/wp-content/uploads/2023/01/Detran-PA-1024x576.jpg" 
                                 alt="Logotipo Detran Pará estampado no painel principal" 
                                 class="rounded-xl shadow-lg border border-slate-200 max-w-full h-auto md:max-h-64 object-cover">
                        </div>
                    </div>
                @endif
            </main>
        </div>
    </div>

    <!-- 📱 BARRA DE NAVEGAÇÃO INFERIOR PARA DISPOSITIVOS MOBILE (Altamente Recomendável para Iniciantes/Idosos) -->
    <!-- Todos os botões contam com áreas ampliadas de toque (min 48x48px) e rótulos claros -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 shadow-xl flex justify-around items-center px-2 z-30" 
         aria-label="Navegação Rápida de Dispositivos Móveis">
        
        <a href="{{ route('dashboard') }}" 
           class="flex flex-col items-center justify-center w-12 h-12 rounded-lg text-slate-600 focus:outline-none focus:ring-2 focus:ring-teal-500 {{ request()->routeIs('dashboard') ? 'text-teal-700 font-bold' : '' }}"
           aria-label="Ir para tela inicial">
            <i class="bi bi-house-door text-xl" aria-hidden="true"></i>
            <span class="text-[10px] tracking-tight">Início</span>
        </a>

        <a href="{{ route('pessoas.index') }}" 
           class="flex flex-col items-center justify-center w-12 h-12 rounded-lg text-slate-600 focus:outline-none focus:ring-2 focus:ring-teal-500 {{ request()->routeIs('pessoas.index') ? 'text-teal-700 font-bold' : '' }}"
           aria-label="Listagem de Pessoas cadastradas">
            <i class="bi bi-people text-xl" aria-hidden="true"></i>
            <span class="text-[10px] tracking-tight">Pessoas</span>
        </a>

        <a href="{{ route('eventos.index') }}" 
           class="flex flex-col items-center justify-center w-12 h-12 rounded-lg text-slate-600 focus:outline-none focus:ring-2 focus:ring-teal-500 {{ request()->routeIs('eventos.index') ? 'text-teal-700 font-bold' : '' }}"
           aria-label="Visualizar Eventos">
            <i class="bi bi-calendar-event text-xl" aria-hidden="true"></i>
            <span class="text-[10px] tracking-tight">Eventos</span>
        </a>

        <a href="{{ route('turmas.index') }}" 
           class="flex flex-col items-center justify-center w-12 h-12 rounded-lg text-slate-600 focus:outline-none focus:ring-2 focus:ring-teal-500 {{ request()->routeIs('turmas.index') ? 'text-teal-700 font-bold' : '' }}"
           aria-label="Ver Turmas cadastradas">
            <i class="bi bi-mortarboard text-xl" aria-hidden="true"></i>
            <span class="text-[10px] tracking-tight">Turmas</span>
        </a>

        <!-- Botão "Mais" - Abre opções secundárias com facilidade (Evita poluir o rodapé do celular) -->
        <button type="button" 
                id="btn-menu-mais"
                class="flex flex-col items-center justify-center w-12 h-12 rounded-lg text-slate-600 focus:outline-none focus:ring-2 focus:ring-teal-500"
                aria-label="Abrir mais opções de menu" 
                aria-expanded="false" 
                aria-controls="drawer-mais-opcoes">
            <i class="bi bi-grid-fill text-xl" aria-hidden="true"></i>
            <span class="text-[10px] tracking-tight">Mais</span>
        </button>
    </nav>

    <!-- DRAWER / MENU DESLIZANTE PARA MÓVEL (Opções Secundárias) -->
    <!-- Proporciona layout limpo, com botões de tamanho ideal para toque fácil -->
    <div id="drawer-mais-opcoes" 
         class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none md:hidden" 
         role="dialog" 
         aria-modal="true" 
         aria-labelledby="drawer-titulo">
        
        <div class="fixed bottom-0 left-0 right-0 bg-white rounded-t-2xl shadow-2xl p-6 transition-transform duration-300 translate-y-full border-t border-slate-100">
            <!-- Barra superior indicativa para fechar (toque ou arrastar simulado) -->
            <div class="w-12 h-1.5 bg-slate-300 rounded-full mx-auto mb-6"></div>
            
            <div class="flex justify-between items-center mb-6">
                <h2 id="drawer-titulo" class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <i class="bi bi-grid text-teal-800" aria-hidden="true"></i>
                    Menu de Opções
                </h2>
                <button type="button" 
                        id="btn-fechar-drawer"
                        class="p-2 text-slate-400 hover:text-slate-600 focus:outline-none focus:ring-2 focus:ring-teal-500 rounded-full"
                        aria-label="Fechar menu de opções">
                    <i class="bi bi-x-lg text-lg" aria-hidden="true"></i>
                </button>
            </div>

            <!-- Links Secundários Mobile com tamanhos de toque generosos (mínimo 48px) -->
            <div class="space-y-3 mb-6">
                <a href="{{ route('usuarios.index') }}" 
                   class="flex items-center gap-3 w-full p-4 rounded-xl text-slate-700 bg-slate-50 hover:bg-slate-100 font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 min-h-[48px]">
                    <i class="bi bi-person text-xl text-teal-700" aria-hidden="true"></i>
                    <span>Gerenciar Usuários</span>
                </a>
                
                <hr class="border-slate-100">

                <div class="p-2 text-center text-xs text-slate-400">
                    Conectado como <strong class="text-slate-600 uppercase">{{ Auth::user()->login_usuario ?? 'Visitante' }}</strong>
                </div>

                <button type="button" 
                        class="flex items-center gap-3 w-full p-4 rounded-xl text-red-600 bg-red-50 hover:bg-red-100 font-semibold focus:outline-none focus:ring-2 focus:ring-red-500 min-h-[48px]"
                        data-bs-toggle="modal"
                        data-bs-target="#logoutModal">
                    <i class="bi bi-box-arrow-right text-xl" aria-hidden="true"></i>
                    <span>Sair do Sistema</span>
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL DE LOGOUT COM COMPATIBILIDADE E ALTA ACESSIBILIDADE -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-2xl border-0 shadow-2xl">
                <div class="modal-header border-b border-slate-100 p-4">
                    <h5 class="modal-title font-bold text-slate-800 text-lg flex items-center gap-2" id="logoutModalLabel">
                        <i class="bi bi-box-arrow-right text-red-600" aria-hidden="true"></i>
                        Confirmar Saída
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar Modal"></button>
                </div>
                <div class="modal-body text-center p-6">
                    <div class="w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-amber-200">
                        <i class="bi bi-exclamation-triangle text-amber-600 text-3xl" aria-hidden="true"></i>
                    </div>
                    <p class="text-slate-600 font-medium text-base">Deseja realmente encerrar sua sessão no sistema?</p>
                </div>
                <div class="modal-footer border-t border-slate-100 p-4 flex justify-end gap-3 bg-slate-50 rounded-b-2xl">
                    <button type="button" 
                            class="px-5 py-2.5 rounded-lg text-slate-600 hover:bg-slate-200 font-semibold focus:outline-none focus:ring-2 focus:ring-slate-400 min-h-[44px]" 
                            data-bs-toggle="modal" 
                            data-bs-target="#logoutModal">Cancelar</button>
                    
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold focus:outline-none focus:ring-2 focus:ring-red-500 min-h-[44px]">
                            Confirmar e Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS DE COMPATIBILIDADE E INTERATIVIDADE (DRAWER E PREVENÇÃO DE DUPLO SUBMIT) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Lógica do Drawer Mobile ("Mais Opções")
            const btnMais = document.getElementById('btn-menu-mais');
            const btnFechar = document.getElementById('btn-fechar-drawer');
            const drawer = document.getElementById('drawer-mais-opcoes');
            const drawerContent = drawer.querySelector('.translate-y-full');

            function abrirDrawer() {
                drawer.classList.remove('opacity-0', 'pointer-events-none');
                drawer.classList.add('opacity-100');
                drawerContent.classList.remove('translate-y-full');
                drawerContent.classList.add('translate-y-0');
                btnMais.setAttribute('aria-expanded', 'true');
                btnFechar.focus(); // Foco vai para o botão de fechar para ajudar a navegação por teclado
            }

            function fecharDrawer() {
                drawer.classList.remove('opacity-100');
                drawer.classList.add('opacity-0', 'pointer-events-none');
                drawerContent.classList.remove('translate-y-0');
                drawerContent.classList.add('translate-y-full');
                btnMais.setAttribute('aria-expanded', 'false');
                btnMais.focus();
            }

            if (btnMais && drawer) {
                btnMais.addEventListener('click', abrirDrawer);
                btnFechar.addEventListener('click', fecharDrawer);
                
                // Fechar ao clicar fora do conteúdo
                drawer.addEventListener('click', function(e) {
                    if (e.target === drawer) fecharDrawer();
                });

                // Suporte à tecla ESC
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && drawer.classList.contains('opacity-100')) {
                        fecharDrawer();
                    }
                });
            }

            // Prevenção de múltiplos envios de formulário com spinner acessível
            $('form').on('submit', function () {
                var botao = $(this).find('button[type="submit"]');
                if (botao.length > 0) {
                    botao.prop('disabled', true);
                    botao.addClass('opacity-75 cursor-not-allowed');
                    botao.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Salvando...');
                }
            });
        });
    </script>
</body>

</html>
