@extends('auth.dashboard')

@section('conteudo')

<style>
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

        <h2 class="fw-bold mb-4 justify-content-start d-flex"
            style="color: #000 !important;">
            <i class="bi bi-person-fill"></i>
            Painel de Usuários Cadastrados
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
                    style="width: 250px; margin-bottom: 10px;"
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
                    <th scope="col">Tipo de Usuário</th>
                    <th scope="col">Status</th>
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
                    <td>{{ $u->tipo_nome }}</td>
                    <td class="text-center">
                        <span class="badge bg-{{ $u->ativo ? 'success' : 'secondary' }}">
                            {{ $u->ativo ? 'Ativo' : 'Inativo' }}
                        </span>
                    <td class="text-center">

                        <div class="d-flex justify-content-center gap-2">

                            <a href="{{ route('usuarios.historico', $u->id_usuario) }}" class="btn btn-outline-secondary btn-visualizar">
                                <i class="bi bi-eye"></i>
                                Visualizar
                            </a>
                            <button type="button"
                                class="btn btn-primary btn-editar"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditar"
                                data-id="{{ $u->id_usuario }}"
                                data-login="{{ $u->login_usuario }}"
                                data-senha=""
                                data-tipo_usuario="{{ $u->id_tipo_usuario }}"
                                data-ativo="{{ $u->ativo }}">
                                <i class="bi bi-pencil-square"></i>
                                Editar
                            </button>

                            <form action="{{ route('usuarios.destroy', $u->id_usuario) }}"
                                  method="POST"
                                  class="m-0" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-deletar">
                                    Deletar
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

<!-- Modal de Edição Adicionado -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="color: teal;">Editar Dados do Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('usuarios.update', '$u->id_usuario') }}" method="POST" id="formEditarPessoa" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editLogin" class="form-label fw-bold">Login</label>
                        <input type="text" name="login_usuario" id="editLogin" class="form-control focus:border-teal-500 outline-none transition-alll" placeholder="Login do Usuário">
                    </div>

                    <div class="mb-3">
                        <label for="senha_usuario" class="form-label fw-bold">Senha</label>
                        <div class="position-relative">
                            <input type="password"
                                   name="senha_usuario"
                                   id="senha_usuario"
                                   class="form-control"
                                   style="padding-right: 2.5rem;"
                                   placeholder="Senha do Usuário">

                            <button type="button"
                                    onclick="togglePassword()"
                                    class="btn border-0 position-absolute end-0 top-50 translate-middle-y"
                                    style="color: teal; background: transparent; z-index: 10;">
                                    <i class="bi bi-eye-fill" id="icon-senha"></i>
                            </button>
                        </div>
                    </div>
                   <div class="row-md-6 mb-3">
                            <label for="editTipoUsuario" class="form-label fw-bold">Tipo de Usuário</label>
                            <select name="id_tipo_usuario" id="editTipoUsuario" class="form-control focus:border-teal-500 outline-none transition-all">
                                <option value="" disabled selected>selecione o tipo de usuário</option>
                                <option value="1">Administrador</option>
                                <option value="2">Treinamento</option>
                                <option value="3">Gabinete</option>
                            </select>
                    </div>
                    <div class="row-md-6 mb-3">
                    <label for="ativo" class="form-label fw-bold">Status</label>
                        <select name="ativo" id="ativo" class="form-control focus:border-teal-500 outline-none transition-all">
                            <option value="" disabled selected>Selecione um tipo</option>
                            <option value="0"{{ old('ativo') == '0' ? 'selected' : '' }}>inativo</option>
                            <option value="1"{{ old('ativo') == '1' ? 'selected' : '' }}>ativo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Salvar mudanças</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.btn-editar').on('click', function() {
            // Pegando os dados do botão ao tentar editar
            const id_usuario = $(this).data('id');
            const login_usuario = $(this).data('login');
            const senha_usuario = $(this).data('senha');;
            const id_tipo_usuario = $(this).data('tipo_usuario');
            const ativo = $(this).data('ativo');



            // Preenchendo os campos do modal com os dados
            $('#editLogin').val(login_usuario);
            $('#editSenha').val(senha_usuario);
            $('#editTipoUsuario').val(id_tipo_usuario);
            $('#ativo').val(ativo);


            // Ajustando a URL do formulário para o ID correto
            let url = "{{ route('usuarios.update', ':id') }}";
            url = url.replace(':id', id_usuario);
            $('#formEditarPessoa').attr('action', url);
        });
    });


    setTimeout(function() {
        var alert = document.querySelector('.alert');
        if (alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);


    function togglePassword() {
        const inputSenha = document.getElementById('senha_usuario');
        const icone = document.getElementById('icon-senha');

        if (inputSenha.type === 'password') {
                inputSenha.type = 'text';
                icone.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
        } else {
            inputSenha.type = 'password';
            icone.classList.replace('bi-eye-slash-fill', 'bi-eye-fill')
        }
    }
</script>
</body>

</html>

@endsection