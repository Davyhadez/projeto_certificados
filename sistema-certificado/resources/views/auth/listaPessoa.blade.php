@extends('auth.dashboard') {{-- Aqui ele puxa toda a interface pronta --}}

@section('conteudo') {{-- Tudo daqui para baixo vai aparecer no lugar do @yield --}}
<title>lista de pessoas</title>
<body>
    <style>
        .btnhistorico {
        display: inline-block;
        background-color: #5fce64;
        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        text-decoration: none;
        line-height: normal;
        transition: background 0.3s;
        }

        .btnEditar {
        display: inline-block;
        background-color: #3498db;
        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        text-decoration: none;
        line-height: normal;
        transition: background 0.3s;
        }

        .btn-deletar {
        background-color: #e74c3c;
        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        transition: background 0.3s;
        }

        td:last-child {
            white-space: nowrap;
            width: 1%;
        }

        .btnEditar, .btnhistorico, .bntDeletar {
            display: inline-block;
            align-items: center;
            justify-content: center;
            height: 38px;
            margin: 0;
        }


        .table-responsive .table th, 
        .table-responsive .table td {
            white-space: nowrap;
            vertical-align: middle;
        }


        .col-acoes {
            width: 1%;
        }


        .form-control:focus, .form-select:focus {
            border-color: teal !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 128, 128, 0.25) !important;
            outline: 0;
        }

        .pesquisar {
            cursor:pointer;
        }
    </style>

    <div class="card shadow-sm border-1 p-3">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h2 class="fw-bold mb-4 justify-content-start d-flex" style="color: teal !important;">
                <i class="bi bi-person-fill"></i>
                Lista de Pessoas
            </h2>
            
            <form action="{{ route('pessoas.index') }}" method="GET">

                <div class="d-flex align-items-center">

                    <label for="pesquisarUser">
                        <h4 class="pesquisar">
                            <i class="bi bi-search" style="padding: 10px;"></i>
                        </h4>
                    </label>

                    <input type="text" 
                        id="pesquisarUser" 
                        name="pesquisarUser" 
                        class="form-control" 
                        value="{{ request('pesquisarUser') }}" 
                        style="width: 250px;" 
                        placeholder="Pesquisar por Nome">
                </div>

            </form>

            <div>
                <a href="{{ route('pessoas.create') }}" 
                    class="btn-teal" 
                    style="padding: 10px; background-color: teal !important; border-radius:5px">
                    <i class="bi bi-person-fill-add"></i>
                    Cadastrar Pessoa
                </a>
            </div>
            
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered m-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">CPF</th>
                        <th scope="col">Matrícula</th>
                        <th scope="col">Lotação</th>
                        <th scope="col">Data de Nascimento</th>
                        <th scope="col" class="text-center col-acoes">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pessoas as $p)
                        <tr>
                            <td>{{ $p->nome_pessoa }}</td>
                            <td>{{ $p->cpf }}</td>
                            <td>{{ $p->matricula }}</td>
                            <td>{{ $p->lotacao -> nome_lotacao ?? 'Não informada' }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->data_nascimento)->format('d/m/Y') }}</td>
                            
                            <td class="text-center">

                                <div class="d-flex justify-content-center gap-2">

                                    <button type="button" class="btn btn-outline-info">Histórico</button>
                                    <button type="button" class="btn btn-outline-secondary">Editar</button>
                                    
                                    <form action="{{ route('pessoas.destroy', $p->id_pessoa) }}" method="POST" class="m-0" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            Danger
                                        </button>
                                    </form>

                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>

@endsection