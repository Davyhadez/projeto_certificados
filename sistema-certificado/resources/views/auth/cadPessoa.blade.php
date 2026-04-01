@extends('auth.dashboard') {{-- Aqui ele puxa toda a interface pronta --}}

@section('conteudo') {{-- Tudo daqui para baixo vai aparecer no lugar do @yield --}}

@section('voltarPessoas')
    <a href="{{ route('pessoas.index') }}"
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
                <i class="bi bi-person-plus-fill me-2"></i>Cadastro de Pessoas
            </h3>
        </div>

        <form action="#" method="POST">
            @csrf
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold" for="nome" >Nome Completo</label>
                    <input type="text" name="nome_pessoa" id="nome" class="form-control" placeholder="Digite o nome" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold" for="cpf">CPF</label>
                    <input type="text" name="cpf" id="cpf" class="form-control" placeholder="000.000.000-00" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold" for="matricula">Matrícula</label>
                    <input type="text" name="matricula" id="matricula" class="form-control" placeholder="Digite a matrícula" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold" for="data_nascimento">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" id="data_nascimento" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="sexo" class="form-label fw-bold">Sexo</label>
                        <select name="sexo" id="sexo" class="form-control">
                            <option value="#" disabled selected>Selecione o gênero</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                </div>
                
                <div class="col-md-6 mb-3">

                    <label class="form-label fw-bold" for="lotacao">Lotação</label>

                        <select name="id_lotacao" id="lotacao" class="form-control">

                            <option value="#" disabled selected >Selecione a unidade</option>
                            @foreach( $lotacoes as $lotacao)
                                <option value="{{ $lotacao -> id }}">{{ $lotacao -> nome_lotacao }}</option>
                            @endforeach
                        </select>

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

                <div class="col-md-6 mb-3">
                    <label for="ativo" class="form-label fw-bold">Ativo</label>
                        <select name="ativo" id="ativo" class="form-control">
                            <option value="#" disabled selected>Selecione um tipo</option>
                            <option value="0">0 (inativo)</option>
                            <option value="1">1 (ativo)</option>
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