@extends('auth.dashboard') {{-- Aqui ele puxa toda a interface pronta --}}

@section('conteudo') {{-- Tudo daqui para baixo vai aparecer no lugar do @yield--}}

    @section('voltarPessoas')
        <a href="{{ route('usuarios.index') }}"
        class="btn-teal-voltar">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    @endsection

        <div class="card-header bg-white py-3">
            <h3 class="fw-bold mb-4 justify-content-center d-flex" style="color: #000 !important;">
                <i class="bi bi-person-lines-fill me-2"></i>{{ $pessoa->nome_pessoa }}
            </h3>
               <div class="row justify-content-center"> <div class="col-md-8"> <div class="card shadow-sm border p-4">

                <div class="col-md-6 mb-3">
                    <h5>Nome: {{ $pessoa->nome_pessoa }}</h5>
                </div>

                <div class="col-md-6 mb-3">
                    <h5>Login: {{ $u->login_usuario }}</h5>
                </div>

                <div class="col-md-6 mb-3">
                    <h5>CPF: {{ $pessoa->cpf }}</h5>
                </div>

                <div class="col-md-6 mb-3">
                    <h5>Data de Nascimento: {{ $pessoa->data_nascimento ? \Carbon\Carbon::parse($pessoa->data_nascimento)->format('d/m/Y') : 'Não informado' }}</h5>
                </div>

                <div class="col-md-6 mb-3">
                    <h5>Sexo: {{ $pessoa->sexo == 'M' ? 'Masculino' : 'Feminino'}}</h5>
                </div>

                <div class="col-md-6 mb-3">
                    <h5>Matrícula: {{ $pessoa->matricula }}</h5>
                </div>

                <div class="col-md-6 mb-3">
                    <h5>Lotação: {{ $pessoa->lotacao->nome_lotacao }}</h5>
                </div>

               <div class="col-md-6 mb-3">
                    <h5>Tipo de Pessoa: {{ $pessoa->id_tipo_pessoa == 1 ? 'Detran' : ($pessoa->id_tipo_pessoa == 2 ? 'Estagiário' : ($pessoa->id_tipo_pessoa == 3 ? 'Prefeitura' : ($pessoa->id_tipo_pessoa == 4 ? 'Terceirizado' : 'Outros'))) }}</h5>
               </div>

                <div class="col-md-6 mb-3">
                    <h5>Tipo de Usuário:
                        {{ $u->tipo_nome }}
                    </h5>
                </div>

                <div class="col-md-6 mb-3">
                    <h5>Status de Usuário: {{ $u->ativo == 1 ? 'Ativo' : 'Inativo' }}</h5>
                </div>
            </div>   
        </div>
@endsection