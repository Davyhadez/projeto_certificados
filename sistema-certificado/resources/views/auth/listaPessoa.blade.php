@extends('auth.dashboard') {{-- Aqui ele puxa toda a interface pronta --}}

@section('conteudo') {{-- Tudo daqui para baixo vai aparecer no lugar do @yield --}}
<title>lista de pessoas</title>

<body>
    <style>
        td:last-child {
            white-space: nowrap;
            width: 1%;
        }

        .table-responsive .table th,
        .table-responsive .table td {
            white-space: nowrap;
            vertical-align: middle;
        }


        .col-acoes {
            width: 1%;
        }


        .form-control:focus,
        .form-select:focus {
            border-color: teal !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 128, 128, 0.25) !important;
            outline: 0;
        }

        .pesquisar {
            cursor: pointer;
        }
    </style>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm"
        role="alert"
        style="background-color: #d1e7dd; color: #0f5132;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm border-1 p-3">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h2 class="fw-bold mb-4 justify-content-start d-flex" style="color: #000 !important;">
                <i class="bi bi-person-fill"></i>
                Painel de Pessoas Cadastradas
            </h2>

            <form action="{{ route('pessoas.index') }}" method="GET">

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
                        style="width: 250px; margin-bottom: 10px;"
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
                        <th scope="col">Status</th>
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
                            <span class="badge bg-{{ $p->ativo ? 'success' : 'secondary' }}">
                                {{ $p->ativo ? 'Ativo' : 'Inativo' }}
                            </span>
                        </td>
                        <td class="text-center">

                            <div class="d-flex justify-content-center gap-2">

                                <a href="{{ route('pessoas.historico', $p ->id_pessoa) }}" class="btn btn-outline-secondary btn-visualizar">
                                    <i class="bi bi-eye"></i>
                                    Visualizar
                                </a>
                                <button type="button"
                                    class="btn btn-primary btn-editar"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditar"
                                    data-id="{{ $p -> id_pessoa }}"
                                    data-cpf="{{ $p -> cpf }}"
                                    data-nome="{{ $p -> nome_pessoa }}"
                                    data-data_nascimento="{{ $p -> data_nascimento }}"
                                    data-sexo="{{ $p -> sexo }}"
                                    data-matricula="{{ $p -> matricula }}"
                                    data-lotacao="{{ $p->id_lotacao }}"
                                    data-tipo_pessoa="{{ $p -> id_tipo_pessoa }}"
                                    data-ativo="{{ $p -> ativo }}">
                                    <i class="bi bi-pencil-square"></i>
                                    Editar
                                </button>

                                <button type="button"
                                    class="btn btn-outline-danger btn-deletar"
                                    data-bs-toggle="modal"
                                    data-bs-target="#confirmDeleteModal"
                                    data-id="{{ $p -> id_pessoa }}"
                                    data-nome="{{ $p -> nome_pessoa }}">
                                    <i class="bi bi-trash"></i>
                                    Deletar
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form action="" method="POST" id="formDeletarPessoa">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-body">
                                        <p>Tem certeza que deseja excluir o (a): <br><strong id="nomePessoaExcluir"></strong><br>Esta ação não poderá ser desfeita.</p>

                                        <div class="mb-3">
                                            <label for="password" class="form-label fw-bold">Digite a sua senha para confirmar:</label>
                                            <input type="password" name="password_confirm" id="password" class="form-control" placeholder="Digite sua senha" required>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger">Confirmar Exclusão</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </tbody>
            </table>
        </div>

        {{-- Essa div é para o controle de paginação --}}
        <div class="d-flex justify-content-center mt-5 mb-3 pagination-container">
            {{ $pessoas->links() }}
        </div>
    </div>
    <div class="modal fade" id="modalEditar" tabindex="1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" style="color: teal;">Editar Pessoa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="formEditarPessoa" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editCPF" class="form-label fw-bold">CPF</label>
                            <input type="text" name="cpf" id="editCPF" class="form-control" placeholder="Digite o CPF" required>
                        </div>
                        <div class="mb-3">
                            <label for="editNome" class="form-label fw-bold">Nome Completo</label>
                            <input type="text" name="nome_pessoa" id="editNome" class="form-control" placeholder="Digite o nome" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDataNascimento" class="form-label fw-bold">Data de Nascimento</label>
                            <input type="date" name="data_nascimento" id="editDataNascimento" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSexo" class="form-label fw-bold">Sexo</label>
                            <select name="sexo" id="editSexo" class="form-control">
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editMatricula" class="form-label fw-bold">Matrícula</label>
                            <input type="text" name="matricula" id="editMatricula" class="form-control" placeholder="Digite a matrícula" required>
                        </div>
                        <div class="mb-3">
                            <label for="editLotacao" class="form-label fw-bold">Lotação</label>
                            <select name="id_lotacao" id="editLotacao" class="form-control">
                                @foreach($lotacoes as $l)
                                <option value="{{ $l->id_lotacao }}">{{ $l->nome_lotacao }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editTipoPessoa" class="form-label fw-bold">Tipo de Pessoa</label>
                            <select name="id_tipo_pessoa" id="editTipoPessoa" class="form-control">
                                <option value="1">Detran</option>
                                <option value="2">Estagiário</option>
                                <option value="3">Prefeitura</option>
                                <option value="4">Terceirizado</option>
                                <option value="5">Outros</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="editAtivo" class="form-label fw-bold">Status</label>
                            <select name="ativo" id="editAtivo" class="form-control">
                                <option value="0">Inativo</option>
                                <option value="1">Ativo</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Salvar mudanças</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Função para carregar dados no Modal de Edição
            $('.btn-editar').on('click', function() {
                const id_pessoa = $(this).data('id');
                const cpf = $(this).data('cpf');
                const nome_pessoa = $(this).data('nome');
                const data_nascimento = $(this).data('data_nascimento');
                const sexo = $(this).data('sexo');
                const matricula = $(this).data('matricula');
                const id_lotacao = $(this).data('lotacao');
                const id_tipo_pessoa = $(this).data('tipo_pessoa');
                const ativo = $(this).data('ativo');

                $('#editCPF').val(cpf);
                $('#editNome').val(nome_pessoa);
                $('#editDataNascimento').val(data_nascimento);
                $('#editSexo').val(sexo);
                $('#editMatricula').val(matricula);
                $('#editLotacao').val(id_lotacao);
                $('#editTipoPessoa').val(id_tipo_pessoa);
                $('#editAtivo').val(ativo);

                let url = "{{ route('pessoas.update', ':id') }}";
                url = url.replace(':id', id_pessoa);
                $('#formEditarPessoa').attr('action', url);
            });

            // Função para carregar dados no Modal de Deleção (A que estava falhando)
            $('.btn-deletar').on('click', function() { // Alterado de .btn-deletar-modal para .btn-deletar
                const id_pessoa = $(this).data('id');
                const nome_pessoa = $(this).data('nome');

                $('#nomePessoaExcluir').text(nome_pessoa);

                // Usamos :id_pessoa para casar com a sua rota do web.php
                let url = "{{ route('pessoas.destroy', ':id_pessoa') }}";
                url = url.replace(':id_pessoa', id_pessoa);

                $('#formDeletarPessoa').attr('action', url);
            });

            // Auto-fechar alertas após 5 segundos
            setTimeout(function() {
                var alertElement = document.querySelector('.alert');
                if (alertElement) {
                    var bsAlert = new bootstrap.Alert(alertElement);
                    bsAlert.close();
                }
            }, 5000);
        });
    </script>
</body>

</html>

@endsection