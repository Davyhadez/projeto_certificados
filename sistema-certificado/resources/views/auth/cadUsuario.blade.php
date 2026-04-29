@extends('auth.dashboard') {{-- Aqui ele puxa toda a interface pronta --}}

@section('conteudo') {{-- Tudo daqui para baixo vai aparecer no lugar do @yield --}}

    @section('voltarPessoas')
        <a href="{{ route('usuarios.index') }}"
        class="btn-teal-voltar">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    @endsection

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <style>

        .form-control:focus, .form-select:focus {
            border-color: teal !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 128, 128, 0.25) !important;
            outline: 0;
        }

    </style>

    <div class="row justify-content-center"> <div class="col-md-6"> <div class="card shadow-sm border p-4">

        <div class="card-header bg-white py-3">
            <h3 class="fw-bold mb-4 justify-content-center d-flex" style="color: #000 !important;">
                <i class="bi bi-person-plus-fill me-2"></i>Cadastro de Usuários
            </h3>
        </div>

        <form action="{{ route('usuarios.store') }}" method="POST" autocomplete="off">
            @csrf
            <div class="row">


                {{-- CAMPO COM O NOME DA PESSOA --}}
                <div class="row-md-6 mb-3">
                    <label class="form-label fw-bold" for="nome" >Nome da Pessoa</label>
                    <select name="id_pessoa" id="nome" class="form-control select-busca">
                        <option value="" disabled selected>Selecione a pessoa</option>
                        @foreach($pessoas as $p)
                            <option value="{{ $p->id_pessoa }}">{{ $p->nome_pessoa }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row-md-6 mb-3">
                    <label class="form-label fw-bold" for="login">Login</label>
                    <input type="text" name="login_usuario" id="login" class="form-control" placeholder="Nome de login" required>
                </div>

                <div class="row-md-6 mb-3">
                    <label class="form-label fw-bold" for="senha">Senha</label>
                    <input type="password" name="senha_usuario" id="senha" class="form-control" placeholder="Digite a senha" required>
                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label fw-bold" for="tipo_usuario">Tipo de Usuário</label>

                        <select name="id_tipo_usuario" id="tipo_usuario" class="form-control">

                            <option value="#" disabled selected>Selecione o tipo</option>
                            <option value="1">Administrador</option>
                            <option value="2">Treinamento</option>
                            <option value="3">Gabinete</option>
                        </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label fw-bold" for="ativo">Status</label>
                    <select name="ativo" id="ativo" class="form-control">
                        <option value="#" disabled selected>Selecione um tipo</option>
                        <option value="1">Ativo (1)</option>
                        <option value="0">Inativo (0)</option>
                    </select>
                </div>
                
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="reset" class="btn-red-limpar">Limpar</button>

                <button type="submit" class="btn-green-salvar">Salvar Cadastro</button>
            </div>
            
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('.select-busca').select2({
                placeholder: "Digite por sobrenome...",
                allowClear: true,
                width: '100%',
                dropwdownAutoWidth: true,
                language: {
                    noResults: function() {
                        return "Nenhum resultado encontrado";
                    }
                }
            });
        });
    </script>
@endsection