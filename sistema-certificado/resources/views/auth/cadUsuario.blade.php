@extends('auth.dashboard') {{-- Aqui ele puxa toda a interface pronta --}}

@section('conteudo') {{-- Tudo daqui para baixo vai aparecer no lugar do @yield --}}

    @section('voltarPessoas')
        <a href="{{ route('usuarios.index') }}"
        class="btn-teal-voltar">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    @endsection

    <style>

        .form-control:focus, .form-select:focus {
            border-color: teal !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 128, 128, 0.25) !important;
            outline: 0;
        }

    </style>

    <div class="card shadow-sm border-1 p-4">

        <div class="card-header bg-white py-3">
            <h3 class="fw-bold mb-4 justify-content-center d-flex" style="color: teal !important;">
                <i class="bi bi-person-plus-fill me-2"></i>Cadastro de Usuários
            </h3>
        </div>

        <form action="#" method="POST">
            @csrf
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold" for="nome" >Nome da Pessoa</label>
                    <select name="id_pessoa" id="nome" class="form-control">
                        <option value="#" disabled selected>Selecione a pessoa</option>
                        @foreach($pessoas as $p)
                            <option value="{{ $p->id_pessoa }}">{{ $p->nome_pessoa }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold" for="login">Login</label>
                    <input type="text" name="login" id="login" class="form-control" placeholder="Nome de login" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold" for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" class="form-control" placeholder="Digite a senha" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold" for="confSenha">Confirmar Senha</label>
                    <input type="password" name="confSenha" id="confSenha" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label fw-bold" for="tipo_pessoa">Tipo de Pessoa</label>

                        <select name="id_tipo_pessoa" id="tipo_pessoa" class="form-control">

                            <option value="#" disabled selected>Selecione o tipo</option>
                            <option value="1">Detran</option>
                            <option value="2">Estagiário</option>
                            <option value="3">Prefeitura</option>
                            <option value="4">Terceirizado</option>
                            <option value="5">Outros</option>

                        </select>

                </div>
                
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="reset" class="btn-red-limpar">Limpar</button>

                <button type="submit" class="btn-green-salvar">Salvar Cadastro</button>
            </div>
            
        </form>
    </div>

@endsection