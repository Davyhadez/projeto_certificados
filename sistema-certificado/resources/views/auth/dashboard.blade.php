<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <title>Sistema de Certificados - DETRAN-PA</title>
    <style>
        html {
            overflow-y: scroll;
        }

        body {
            overflow-x: hidden;
            background-color: #f8f9fa;
            margin: 0;
        }

        .sidebar {
            min-height: 100vh;
            width: 250px;
            background-color: #0a5c5c;
            color: white;
            position: fixed;
            left: 0;
            top: 0;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar .nav-item {
            color: white;
            text-decoration: none;
            display: block;
            padding: 1px;
            border-radius: 5px;
            text-align: center;
        }

        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
        }

        .top-navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
            height: 60px;
        }

        #menuCadastro .bg-white a {
        font-size: 1.0rem;
        padding-left: 10px;
        transition: 0.3s;
            }

        #menuCadastro1 .bg-white a {
        font-size: 1.0rem;
        padding-left: 10px;
        transition: 0.3s;
            }

        #menuCadastro .bg-white a:hover {
        background-color: #f8f9fa;
        color: teal !important;
        }

        #menuCadastro1 .bg-white a:hover {
        background-color: #f8f9fa;
        color: teal !important;
        }


        .detran {
            max-width: 60%;
            height: auto;
            margin-top: 50px;
        }

        .nav-btn {
            background-color: transparent; 
            transition: all 0.3s ease; 
            font-size: 20px;
        }

        .nav-sair-btn {
            background: transparent; 
            border: 1px solid transparent;
            transition: all 0.3s ease; 
            font-size: 20px;
        }

        .nav-sair-btn:hover {
            background-color: #ff3a3acf;
            color: #ffffff !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
            transform: scale(1.02);
        }

        .nav-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
            transform: scale(1.02); 
        }

        .nav-btn.active {
            background-color: rgba(255, 255, 255, 0.1) !important;
        }

        .sidebar ul {
            padding-left: 0;
            list-style: none;
        }
    </style>
</head>

<body>

    <div class="d-flex">
        <div class="sidebar p-3">

            <div class="header-container d-flex align-items-center gap-3 p-3" style="background-color: #0a5c5c;">
                <img src="https://www.detran.pa.gov.br/assets_news/images/Logodetran_icon.png"
                     alt="logo DETRAN-PA"
                     class="img-fluid object-fit-contain"
                     style="max-width: 120px; height: auto; display: block; margin: 0 auto">
            </div>
            <h4 class="text-center mb-3 mt-1 fw-bold">Sistema de Certificados</h4>

            <hr style="border-top: 3px solid rgb(255, 255, 255);">

            <ul>
                <li class="nav-item">
                    <div class="rounded p-1">
                        <a href="{{ route('dashboard') }}" 
                        class="nav-btn rounded d-block text-white text-decoration-none p-2 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <div class="rounded p-1">
                        <a href="{{ route('usuarios.index') }}" 
                        class="nav-btn rounded d-block text-white text-decoration-none p-2 {{ request()->routeIs('usuarios.index') ? 'active' : '' }}">
                            <i class="bi bi-person"></i> Usuários
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <div class="rounded p-1">
                        <a href="{{ route('pessoas.index') }}" 
                        class="nav-btn rounded d-block text-white text-decoration-none p-2 {{ request()->routeIs('pessoas.index') ? 'active' : '' }}">
                            <i class="bi bi-people"></i> Pessoas
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <div class="rounded p-1">
                        <a href="{{ route('eventos.index') }}" 
                        class="nav-btn rounded d-block text-white text-decoration-none p-2 {{ request()->routeIs('eventos.index') ? 'active' : '' }}">
                            <i class="bi bi-calendar-event"></i> Eventos
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <div class="rounded p-1">
                        <a href="{{ route('turmas.index') }}" 
                        class="nav-btn rounded d-block text-white text-decoration-none p-2 {{ request()->routeIs('turmas.index') ? 'active' : '' }}">
                            <i class="bi bi-mortarboard"></i> Turmas
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <div class="rounded p-1">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="button" class="nav-sair-btn rounded d-block text-white text-decoration-none p-2"
                                    style="width: 100%; border: none;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#logoutModal">
                                <i class="bi bi-box-arrow-right"></i> Sair
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>

        <div class="main-content">
            <nav class="navbar top-navbar px-4 py-2 d-flex justify-content-between align-items-center">

                <div>
                    <a id="nav-left">
                    @yield('voltarPessoas')
                </div>
                
                <div class="d-flex align-items-center">
                    <span class="me-3 fw-bold text-uppercase">
                        {{ Auth::user()->login_usuario }} <i class="bi bi-person-circle"></i>
                    </span>
                </div>
            </nav>

            <div class="container-fluid p-5">
                    {{-- 1. Se existir uma @section('conteudo'), mostre-a --}}
                    @if(View::hasSection('conteudo'))
                        @yield('conteudo')
    
                        {{-- 2. Se NÃO existir (ou seja, se for a Home), mostre a logo --}}
                     @else
                <div class="card shadow p-3 mb-5 bg-body rounded border-0 p-5 text-center">
                    <h1 class="fw-bold">Seja bem-vindo ao sistema de certificados</h1>
                    <div>
                        <img src="https://www.motoragora.com.br/wp-content/uploads/2023/01/Detran-PA-1024x576.jpg" alt="logo" class="detran">
                    </div>
                </div> 
                    @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-1">
                    <h5 class="modal-title fw-bold" id="logoutModalLabel">Confirmar Saída</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                    <p class="mt-3 fs-5">Deseja realmente encerrar sua sessão no sistema?</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancelar</button>
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger px-4">Confirmar e Sair</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>