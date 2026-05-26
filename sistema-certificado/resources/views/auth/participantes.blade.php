@extends('auth.dashboard') {{-- Puxa o seu layout padrão --}}

@section('conteudo') {{-- Insere o conteúdo no yield correto --}}

@section('voltarPessoas')
    <a href="{{ route('turmas.index') }}" class="btn-teal-voltar">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
@endsection

<div class="container my-5">
    <div class="card shadow-sm border border-light-subtle rounded p-4 bg-white" style="max-width: 1200px; margin: 0 auto;">
        
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-900">
            {{ $turma->evento->nome_evento ?? 'Curso técnico de psicologia' }}
        </h1>

        <div class="mb-4">
            <h5 class="fw-bold text-secondary mb-3" style="font-size: 1.1rem;">Informações do evento:</h5>
            <div class="lh-sm text-secondary" style="font-size: 0.95rem;">
                <p class="mb-1"><strong class="text-dark">Local evento:</strong> {{ $turma->local_oferta ?? 'Ananindeua' }}</p>
                <p class="mb-1">
                    <strong class="text-dark">Carga horária:</strong> 
                    @if($turma->evento->id_tipo_evento == 1)
                        {{ $turma->evento->disciplinas->sum('carga_horaria') }}
                    @else
                        {{ $turma->evento->carga_horaria ?? '0' }}
                    @endif h
                </p>
                <p class="mb-1"><strong class="text-dark">Data de início:</strong> {{ $turma->data_inicio ? \Carbon\Carbon::parse($turma->data_inicio)->format('d/m/Y') : 'N/A' }}</p>
                <p class="mb-1"><strong class="text-dark">Data fim:</strong> {{ $turma->data_fim ? \Carbon\Carbon::parse($turma->data_fim)->format('d/m/Y') : 'N/A' }}</p>
                <p class="mb-1"><strong class="text-dark">Descrição:</strong></p>
                <p class="text-muted ps-3 mb-0">{{ $turma->descricao ?? 'teste' }}</p>
            </div>
        </div>

        <div class="mb-4">
            <button class="btn text-white px-4 py-2 btn-teal">
                Fechar turma
            </button>
        </div>

        <hr class="text-secondary opacity-25 mb-4">

        {{-- SEÇÃO DE INSTRUTORES --}}
        <div class="mb-5">
            <h5 class="fw-bold text-dark mb-3">Instrutores:</h5>
            
            <div class="table-responsive border rounded">
                <table class="table table-bordered mb-0 align-middle" style="font-size: 0.9rem;">
                    <thead class="table-light text-center">
                        <tr>
                            <th class="fw-bold text-secondary text-start ps-4" style="width: 70%;">Instrutor</th>
                            <th class="fw-bold text-secondary">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($turma->instrutores as $instrutor)
                            <tr>
                                <td class="ps-4">{{ $instrutor->nome_pessoa }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-4">
                                        <button class="btn btn-outline-success btn-emitir">
                                            Emitir Certificado
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-4 font-italic bg-white">
                                    Este evento ainda não tem instruores selecionados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-center">
                <button type="button" class="btn btn-primary px-4 shadow-sm btn-teal" data-bs-toggle="modal" data-bs-target="#modalAddInstrutor">
                    Adicionar instrutor
                </button>
            </div>
        </div>

        {{-- SEÇÃO DE ALUNOS --}}
        <div class="mb-2">
            <h5 class="fw-bold text-dark mb-3">
                Alunos({{ $turma->alunos->count() }}/20):
            </h5>
            
            <div class="table-responsive border rounded">
                <table class="table table-bordered mb-0 align-middle" style="font-size: 0.9rem;">
                    <thead class="table-light text-center">
                        <tr>
                            <th class="fw-bold text-secondary text-start ps-4" style="width: 40%;">Aluno</th>
                            <th class="fw-bold text-secondary" style="width: 10%;">Conceito</th>
                            <th class="fw-bold text-secondary">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($turma->alunos as $aluno)
                            <tr>
                                <td class="ps-4">{{ $aluno->nome_pessoa }}</td>
                                <td class="text-center">{{ $aluno->pivot->conceito ?? 'Pendente' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-4">
                                        <button class="btn btn-outline-success btn-emitir">
                                            Emitir Certificado
                                        </button>
                                        <button class="btn btn-outline-success btn-emitir">
                                            Baixar Frequência da Turma
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4 font-italic bg-white">
                                    Este evento ainda não tem alunos inscritos.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-center">
                <button type="button" class="btn btn-primary px-4 shadow-sm btn-teal" data-bs-toggle="modal" data-bs-target="#modalAddAlunos">
                    Adicionar Pessoas
                </button>
            </div>
        </div>

    </div>
</div>

{{-- ========================================================== --}}
{{-- MODAL: ADICIONAR INSTRUTOR                                 --}}
{{-- ========================================================== --}}
<div class="modal fade" id="modalAddInstrutor" tabindex="-1" aria-labelledby="modalAddInstrutorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white" style="background-color: teal;">
                <h5 class="modal-title" id="modalAddInstrutorLabel">Adicionar instrutor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-shadow="none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="max-height: 70vh; overflow-y: auto;">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-secondary">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="buscaInstrutor" class="form-control border-start-0 ps-0" placeholder="Digite o nome para pesquisar...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center" style="font-size: 0.9rem;">
                        <thead class="table-light">
                            <tr>
                                <th class="text-start ps-3">Nome</th>
                                <th>CPF</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        {{-- CORRIGIDO: Adicionado id para o JS encontrar o corpo da tabela --}}
                        <tbody id="tabelaPessoasModal">
                            @foreach($instrutoresDisponiveis as $p)
                            <tr>
                                {{-- CORRIGIDO: Adicionada a classe nome-item --}}
                                <td class="text-start ps-3 fw-medium nome-item">{{ $p->nome_pessoa }}</td>
                                <td class="text-muted">{{ $p->cpf }}</td>
                                <td>
                                    <button class="btn btn-success btn-sm px-3"><i class="bi bi-check2"></i> Adicionar</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ========================================================== --}}
{{-- MODAL: ADICIONAR ALUNOS (PESSOAS)                          --}}
{{-- ========================================================== --}}
<div class="modal fade" id="modalAddAlunos" tabindex="-1" aria-labelledby="modalAddAlunosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white" style="background-color: teal;">
                <h5 class="modal-title" id="modalAddAlunosLabel">Adicionar Pessoas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="max-height: 70vh; overflow-y: auto;">
                {{-- NOVO: Caixa de pesquisa adicionada também no modal de alunos --}}
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-secondary">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="buscaAluno" class="form-control border-start-0 ps-0" placeholder="Digite o nome para pesquisar...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center" style="font-size: 0.9rem;">
                        <thead class="table-light">
                            <tr>
                                <th class="text-start ps-3">Nome</th>
                                <th>CPF</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        {{-- CORRIGIDO: Adicionado id e preparado o loop para quando você configurar os alunos no controller --}}
                        <tbody id="tabelaAlunosModal">
                            @foreach($instrutoresDisponiveis as $p)
                            <tr>
                                <td class="text-start ps-3 fw-medium nome-item">{{ $p->nome_pessoa }}</td>
                                <td class="text-muted">{{ $p->cpf }}</td>
                                <td>
                                    <button class="btn btn-success btn-sm px-3"><i class="bi bi-check2"></i> Adicionar</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT DE FILTRO EM TEMPO REAL --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    
    function configurarFiltro(idInput, idTbody) {
        const inputBusca = document.getElementById(idInput);
        const tbody = document.getElementById(idTbody);
        
        if (inputBusca && tbody) {
            const linhas = tbody.getElementsByTagName('tr');

            inputBusca.addEventListener('keyup', function () {
                const filtro = inputBusca.value.toUpperCase();

                for (let i = 0; i < linhas.length; i++) {
                    const colunaNome = linhas[i].querySelector('.nome-item');
                    
                    if (colunaNome) {
                        const textoNome = colunaNome.textContent || colunaNome.innerText;
                        
                        if (textoNome.toUpperCase().indexOf(filtro) > -1) {
                            linhas[i].style.display = "";
                        } else {
                            linhas[i].style.display = "none";
                        }
                    }
                }
            });
        }
    }

    configurarFiltro('buscaInstrutor', 'tabelaPessoasModal');
    configurarFiltro('buscaAluno', 'tabelaAlunosModal');
});
</script>

@endsection