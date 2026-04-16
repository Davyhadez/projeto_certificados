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

        .sidebar .nav-link,
        .sidebar .nav-item {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.1);
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
            max-width: 50%;
            height: auto;
            margin-top: 40px;
        }
    </style>
</head>

<body>

    <div class="d-flex">
        <div class="sidebar p-3">
            <h2 class="text-center mb-4 mt-2 fw-bold">Sistema de Certificados</h2>
            <ul>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link active fw-bold"><i class="bi bi-house-door-fill"></i> Home</a>
                </li>
                <hr style="color: #e0e9ff">

                <li class="nav-item">

                        <div class="rounded p-2" style="background-color: rgba(255, 255, 255, 0.1);">
                            <a href="{{ route('usuarios.index') }}" class="d-block text-white text-decoration-none py-1 fw-bold">Lista de Usuários</a>
                        </div>

                </li>

                <li class="nav-item">

                        <div class="rounded p-2" style="background-color: rgba(255, 255, 255, 0.1);">
                            <a href="{{ route('pessoas.index') }}" class="d-block text-white text-decoration-none py-1 fw-bold">Lista de Pessoas</a>
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
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger">Sair</button>
                    </form>
                </div>
            </nav>

            <div class="container-fluid p-5">
                    {{-- 1. Se existir uma @section('conteudo'), mostre-a --}}
                    @if(View::hasSection('conteudo'))
                        @yield('conteudo')
    
                        {{-- 2. Se NÃO existir (ou seja, se for a Home), mostre a logo --}}
                     @else
                <div class="card shadow p-3 mb-5 bg-body rounded border-0 p-5 text-center">
                    <h2 class="fw-bold">Seja bem-vindo ao sistema de certificados</h2>
                    <div>
                        <img src="https://www.motoragora.com.br/wp-content/uploads/2023/01/Detran-PA-1024x576.jpg" alt="logo" class="detran">
                    </div>
                </div> 
                    @endif
            </div>
        </div>
    </div>
</body>

</html>