







@extends('auth.dashboard')

{{-- SEÇÃO DO BOTÃO VOLTAR --}}
@section('voltarPessoas')
<a href="{{route('turmas.index', $turma->id_turma)}}" class="btn-teal-voltar">
    <i class="bi bi-arrow-left"></i> Voltar
</a>
@endsection

{{-- INÍCIO DA SEÇÃO DE CONTEÚDO PRINCIPAL --}}
@section('conteudo') 

<div class="container my-5">
    <div class="card shadow-sm border border-light-subtle rounded p-4 bg-white" style="max-width: 1200px; margin: 0 auto;">

        <h1 class="text-2xl font-bold mb-6 text-center text-gray-900">
            {{ $turma->evento->nome_evento ?? 'Erro ao carregar o nome do evento' }}
        </h1>

        <div class="mb-4">
            <h5 class="fw-bold text-dark mb-3" style="font-size: 1.1rem;">Informações do evento:</h5>
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
                <p class="mb-1"><strong class="text-dark">Descrição:</strong> {{ $turma->descricao ?? 'Sem descrição.' }}</p>
            </div>
            <br>

            {{-- STATUS 1: BOTÃO: FECHAR TURMA --}}
            @if((int)$turma->id_situacao_turma === 1)
            <div class="mb-4">
                <form action="{{ route('turmas.fechar', $turma->id_turma ?? $turma->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn text-white px-4 py-2 btn-teal" onclick="return confirm('Deseja realmente fechar esta turma?')">
                        Fechar turma
                    </button>
                </form>
            </div>
            @endif       
            
            {{-- STATUS 4: FUNCIONALIDADES DE LANÇAMENTO --}}
            @if((int)$turma->id_situacao_turma === 4)
            <div class="alert alert-info mt-3" style="background-color: #e3f2fd; color: #0d47a1; border-left: 5px solid #0d47a1; padding: 15px; border-radius: 4px;">
                <strong>Turma fechada!</strong> Agora você pode lançar os conceitos dos alunos.
            </div>

            <div class="d-flex align-items-center gap-3 my-3 p-3 bg-light border rounded flex-wrap">
                <form action="{{ route('turmas.frequencia', $turma->id_turma) }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2 m-0">
                    @csrf
                    <span class="text-secondary font-weight-bold">Lance a frequência:</span>
                    <input type="file" name="arquivo_frequencia" class="form-control form-control-sm" style="width: auto;" required>
                    <button type="submit" class="btn btn-outline-primary btn-sm">Enviar</button>
                </form>

                <a href="{{ route('turmas.conceitos', $turma->id_turma) }}" class="btn btn-outline-success btn-sm font-weight-bold">
                    Lançar Conceito
                </a>
            </div>
            @endif    
            
            {{-- STATUS 3: AVISO: AGUARDANDO ASSINATURA --}}
            @if((int)$turma->id_situacao_turma === 3 && $turma->certificado_liberado != 1)
            <div class="alert alert-warning mt-3" style="background-color: #fffde7; color: #f57f17; border-left: 5px solid #f57f17; padding: 15px; border-radius: 4px;">
                <strong>Certificados em processo de assinatura.</strong> Aguarde a conclusão da assinatura pelo coordenador. Os certificados serão liberados automaticamente.
            </div>
            @endif

            {{-- STATUS LIBERADO: AVISO: CERTIFICADOS PRONTOS --}}
            @if((int)$turma->id_situacao_turma === 2 || $turma->certificado_liberado == 1)
            <div class="alert alert-success mt-3" style="background-color: #d1e7dd; color: #0f5132; border-left: 5px solid #0f5132; padding: 15px; border-radius: 4px;">
                <strong><i class="bi bi-check-circle-fill me-1"></i>Certificados liberados!</strong> As assinaturas foram concluídas e os certificados estão disponíveis para emissão.
            </div>
            @endif

            {{-- SEÇÃO EXTRA: DISCIPLINAS --}}
            @if($turma->id_situacao_turma != 1)
            <div class="mb-4">
                <h5 class="fw-bold text-dark mb-2">Disciplinas:</h5>
                <div class="border rounded p-3 bg-light">
                    @if($turma->evento && $turma->evento->id_tipo_evento == 1 && $turma->evento->disciplinas->count() > 0)
                    @foreach($turma->evento->disciplinas as $disciplina)
                    <span class="badge bg-white text-dark border p-2 me-2 mb-2">{{ $disciplina->nome_disciplina }}</span>
                    @endforeach
                    @else
                    <span class="text-muted">aula01</span>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
    
<div class="container my-1">
    <div class="card shadow-sm border border-light-subtle rounded p-4 bg-white" style="max-width: 1200px; margin: 0 auto;">
        
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
                                <div class="d-flex justify-content-center gap-2">
                                    @if($turma->certificado_liberado == 1)
                                    {{-- Certificado liberado: botão de emissão ativo --}}
                                    <button class="btn btn-outline-success btn-sm px-3">
                                        <i class="bi bi-file-earmark-check me-1"></i>Emitir Certificado
                                    </button>
                                    @else
                                    {{-- Certificado não liberado: botão de exclusão ou pendente --}}
                                    @if($turma->id_situacao_turma >= 3)
                                    <button class="btn btn-outline-secondary btn-sm px-3" disabled title="Aguardando liberação da assinatura.">
                                        <i class="bi bi-hourglass-split me-1"></i>Certificado Pendente
                                    </button>
                                    @else
                                    <form action="{{ route('turmas.removerInstrutor', [$turma->id_turma ?? $turma->id, $instrutor->id_pessoa]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm px-2" title="Remover Instrutor" onclick="return confirm('Remover este instrutor da turma?')">
                                            <i class="bi bi-person-dash"></i> Excluir Instrutor
                                        </button>
                                    </form>
                                    @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted py-4 font-italic bg-white">
                                Este evento ainda não tem instrutores selecionados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($turma->id_situacao_turma == 1)
            <div class="mt-3 d-flex justify-content-center">
                <button type="button" class="btn btn-primary px-4 shadow-sm btn-teal" data-bs-toggle="modal" data-bs-target="#modalAddInstrutor">
                    Adicionar instrutor
                </button>
            </div>
            @endif
        </div>

        {{-- SEÇÃO DE ALUNOS --}}
        <div class="mb-2">
            <h5 class="fw-bold text-dark mb-3">
                Alunos ({{ $turma->alunos->count() }}/20):
            </h5>

            <div class="table-responsive border rounded">
                <table class="table table-bordered mb-0 align-middle" style="font-size: 0.9rem;">
                    <thead class="table-light text-center">
                        <tr>
                            <th class="fw-bold text-secondary text-start ps-4" style="width: 60%;">Aluno</th>
                            <th class="fw-bold text-secondary" style="width: 10%;">Conceito</th>
                            <th class="fw-bold text-secondary">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($turma->alunos as $aluno)
                        <tr>
                            <td class="ps-4">{{ $aluno->nome_pessoa }}</td>
                            <td class="text-center">{{ $aluno->pivot->conceito ?? '---' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    @if($turma->certificado_liberado == 1)
                                    {{-- Certificado liberado: botão de emissão ativo --}}
                                    <button class="btn btn-outline-success btn-sm px-3">
                                        <i class="bi bi-file-earmark-check me-1"></i>Emitir Certificado
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm px-3">
                                        <i class="bi bi-download me-1"></i>Baixar Frequência da Turma
                                    </button>
                                    @else
                                    {{-- Certificado não liberado: botão de exclusão ou pendente --}}
                                    @if($turma->id_situacao_turma >= 3)
                                    <button class="btn btn-outline-secondary btn-sm px-3" disabled title="Aguardando liberação da assinatura.">
                                        <i class="bi bi-hourglass-split me-1"></i>Certificado Pendente
                                    </button>
                                    @else
                                    <form action="{{ route('turmas.removerAluno', [$turma->id_turma ?? $turma->id, $aluno->id_pessoa]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm px-2" title="Remover Aluno" onclick="return confirm('Remover este aluno da turma?')">
                                            <i class="bi bi-person-dash"></i> Excluir Aluno
                                        </button>
                                    </form>
                                    @endif
                                    @endif
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

            @if($turma->id_situacao_turma == 1)
            <div class="mt-3 d-flex justify-content-center">
                <button type="button" class="btn btn-primary px-4 shadow-sm btn-teal" data-bs-toggle="modal" data-bs-target="#modalAddAlunos">
                    Adicionar Pessoas
                </button>
            </div>
            @endif
        </div>

    </div>
</div>

{{-- MODAL: ADICIONAR INSTRUTOR --}}
<div class="modal fade" id="modalAddInstrutor" tabindex="-1" aria-labelledby="modalAddInstrutorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white" style="background-color: teal;">
                <h5 class="modal-title" id="modalAddInstrutorLabel">Adicionar instrutor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <tbody id="tabelaPessoasModal">
                            @foreach($instrutoresDisponiveis as $p)
                            <tr>
                                <td class="text-start ps-3 fw-medium nome-item">{{ $p->nome_pessoa }}</td>
                                <td class="text-muted">{{ $p->cpf }}</td>
                                <td>
                                    <form action="{{ route('turmas.vincularInstrutor', $turma->id_turma ?? $turma->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_pessoa" value="{{ $p->id_pessoa }}">
                                        <button type="submit" class="btn btn-success btn-sm px-3">
                                            <i class="bi bi-check2"></i> Adicionar
                                        </button>
                                    </form>
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

{{-- MODAL: ADICIONAR ALUNOS --}}
<div class="modal fade" id="modalAddAlunos" tabindex="-1" aria-labelledby="modalAddAlunosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white" style="background-color: teal;">
                <h5 class="modal-title" id="modalAddAlunosLabel">Adicionar Pessoas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="max-height: 70vh; overflow-y: auto;">
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
                        <tbody id="tabelaAlunosModal">
                            @foreach($instrutoresDisponiveis as $p)
                            <tr>
                                <td class="text-start ps-3 fw-medium nome-item">{{ $p->nome_pessoa }}</td>
                                <td class="text-muted">{{ $p->cpf }}</td>
                                <td>
                                    <form action="{{ route('turmas.vincularAluno', $turma->id_turma ?? $turma->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_pessoa" value="{{ $p->id_pessoa }}">
                                        <button type="submit" class="btn btn-success btn-sm px-3">
                                            <i class="bi bi-check2"></i> Adicionar
                                        </button>
                                    </form>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function configurarFiltro(idInput, idTbody) {
            const inputBusca = document.getElementById(idInput);
            const tbody = document.getElementById(idTbody);

            if (inputBusca && tbody) {
                const linhas = tbody.getElementsByTagName('tr');

                inputBusca.addEventListener('keyup', function() {
                    const filtro = inputBusca.value.toUpperCase();

                    for (let i = 0; i < linhas.length; i++) {
                        const colunaNome = linhas[i].querySelector('.nome-item');

                        if (colunaNome) {
                            const textoNome = colunaNome.textContent || colunaNome.innerText;

                            if (textoNome.toUpperCase().indexOf(filtro) > -1) {
                                linhas[i].style.display = "";
                            } else {
                                linhas[i].style.display = "none"; // Corrigido de lines[i] para linhas[i]
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