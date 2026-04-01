@extends('auth.dashboard')

@section('conteudo')

    <div class="card shadow-sm border-1 p-3">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h2 class="fw-bold mb-4 justify-content-start d-flex"
            style="color: teal !important;">
                <i class="bi bi-person-fill"></i>
                Lista de Usuários
            </h2>
            
            <form action="{{ route('usuarios.index') }}" method="GET">

                <div class="d-flex align-items-center">

                    <label for="pesquisarUser">
                        <h4 class="pesquisar">
                            <i class="bi bi-search"
                            style="padding: 10px;"></i>
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
                <a href="{{ route('usuarios.create') }}" 
                    class="btn-teal" 
                    style="padding: 10px; background-color: teal !important; border-radius:5px">
                    <i class="bi bi-person-fill-add"></i>
                    Cadastrar Usuário
                </a>
            </div>
            
        </div>

        <div class="table-responsive">

            <table class="table table-striped table-hover table-bordered m-0">

                <thead class="table-light">

                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Login</th>
                        <th scope="col">Matrícula</th>
                        <th scope="col">Lotação</th>
                        <th scope="col">Data de Nascimento</th>
                        <th scope="col" class="text-center col-acoes">Ações</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach($usuarios as $u)
                        <tr>
                            <td>{{ $u->pessoa->nome_pessoa }}</td>
                            <td>{{ $u->login_usuario }}</td>
                            <td>{{ $u->pessoa->matricula }}</td>
                            <td>{{ $u->lotacao->nome_lotacao ?? 'Não informada' }}</td>
                            <td>{{ \Carbon\Carbon::parse($u->pessoa->data_nascimento)->format('d/m/Y') }}</td>

                            <td class="text-center">

                                <div class="d-flex justify-content-center gap-2">

                                    <button type="button" class="btn btn-outline-info">Histórico</button>
                                    <button type="button" class="btn btn-outline-secondary">Editar</button>
                                    
                                    <form action="{{ route('pessoas.destroy', $u->pessoa->id_pessoa) }}" method="POST" class="m-0" onsubmit="return confirm('Tem certeza que deseja excluir?')">
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