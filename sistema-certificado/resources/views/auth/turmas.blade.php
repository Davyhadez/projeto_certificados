@extends('auth.dashboard')

@section('conteudo')

<div class="card shadow-sm border-1 p-4">
    <div class="card shadow-sm border-0 p-1">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold mb-4 justify-content-start d-flex" style="color: #000;">
                <i class="bi bi-person-workspace me-2" style="color: #000;"></i>Consulta de Turmas
            </h2>

            <button type="button"
                class="btn-teal d-flex align-items-center"
                data-bs-toggle="modal"
                data-bs-target="#modalCadastrarTurma">
                <i class="bi bi-plus-circle-fill me-2"></i>
                Cadastrar Turma
            </button>
        </div>

        <form action="#" method="GET">
            <div class="d-flex align-items-center">
                <label for="pesquisarTurma">
                    <h4 class="pesquisar">
                        <i class="bi bi-search" style="padding: 10px;"></i>
                    </h4>
                </label>

                <input type="text"
                    id="pesquisarTurma"
                    name="pesquisarTurma"
                    class="form-control"
                    style="width: 250px; margin-bottom: 10px;"
                    placeholder="Pesquisar por Turma">
            </div>
        </form>

{{-- ================================ --}}
{{-- CONTAINER: PARA ALERTAS FLUENTES --}}
{{-- ================================ --}}

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center rounded border-0 shadow-sm p-3 mb-4" role="alert" style="background-color: #d1e7dd; color: #0f5132;">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center rounded border-0 shadow-sm p-3 mb-4" role="alert" style="background-color: #f8d7da; color: #842029;">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover table-compacta table-bordered">
                <thead class="table-light">
                    <tr class="text-uppercase" style="font-size: 0.9rem;">
                        <th scope="col" class="text-center" style="width: 20%;">Evento</th>
                        <th scope="col" class="text-center" style="width: 5%;">Status</th>
                        <th scope="col" class="text-center" style="width: 5%;">Local</th>
                        <th scope="col" class="text-center" style="width: 12%;">Total de Alunos</th>
                        <th scope="col" class="text-center" style="width: 10%;">Carga Horária</th>
                        <th scope="col" class="text-center" style="width: 15%;">Período (Início/Fim)</th>
                        <th scope="col" class="text-center" style="width: 13%;">Data de Registro</th>                       
                        <th scope="col" class="text-center col-acoes">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @if($turmas->count() > 0)
                        @foreach($turmas as $turma)
                            <tr>
                                <td class="none">{{ $turma->evento->nome_evento ?? 'Evento não encontrado' }}</td>
                                <td class="text-center">
                                    @if($turma->certificado_liberado == 1)
                                        <span class="badge bg-success text-uppercase" style="font-size: 0.8rem; padding: 5px 10px;">Liberado</span>
                                    @else
                                        <span class="badge bg-warning text-uppercase" style="font-size: 0.8rem; padding: 5px 10px;">Pendente</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $turma->local_oferta }}</td>
                                <td class="text-center fw-bold">
                                    {{ $turma->alunos_count ?? 0 }}/{{ $turma->quantidade_maxima }}
                                </td> 
                                <td class="text-center">
                                    @if($turma->evento->id_tipo_evento == 1)
                                    <strong>{{ $turma->evento->disciplinas->sum('carga_horaria') }}</strong> HORAS/AULA
                                    @else
                                    {{-- Valor fixo para PALESTRAS --}}
                                    {{ $turma->evento->carga_horaria }} HORAS/AULA
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ $turma->data_inicio ? \Carbon\Carbon::parse($turma->data_inicio)->format('d/m/Y') : 'N/A' }} - 
                                    {{ $turma->data_fim ? \Carbon\Carbon::parse($turma->data_fim)->format('d/m/Y') : 'N/A' }}
                                </td>
                                <td class="text-center">
                                    {{ $turma->data_registro ? \Carbon\Carbon::parse($turma->data_registro)->format('d/m/Y') : 'N/A' }}
                                </td>                        
                                <td class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('turmas.participantes', ['id' => $turma->id_turma]) }}" class="btn btn-sm btn-outline-secondary fw-bold btn-visualizar-turma" title="Ver Alunos">
                                        <i class="bi bi-people-fill"></i> Participantes
                                    </a>

                                    <button type="button" class="btn btn-sm btn-primary btn-editar-turma"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditarTurma"
                                        data-id="{{ $turma->id_turma }}"
                                        data-id-evento="{{ $turma->id_evento }}"
                                        data-qtd-atual="{{ $turma->alunos_count ?? 0 }}"
                                        data-descricao="{{ $turma->descricao }}"
                                        data-local="{{ $turma->local_oferta }}"
                                        data-qtd-maxima="{{ $turma->quantidade_maxima }}"
                                        data-data-inicio="{{ $turma->data_inicio }}"
                                        data-data-fim="{{ $turma->data_fim }}"
                                        >
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </button>

                                    <form action="{{ route('turmas.destroy', $turma->id_turma) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta turma?')">
                                        @csrf
                                        @method('DELETE') <button type="submit" class="btn btn-sm btn-outline-danger btn-deletar-turma">
                                            <i class="bi bi-trash"></i> <span>Deletar</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center text-muted">Nenhuma turma encontrada no banco de dados.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3 text-muted" style="font-size: 0.85rem;">
            <div>
                Total de turmas: <span class="fw-bold">{{ $turmas->count() }}</span>
            </div>
        </div>
    </div>
</div>


{{-- MODAL DE CADASTRAR TURMA --}}
<div class="modal fade" id="modalCadastrarTurma" tabindex="-1" aria-labelledby="modalCadastrarTurmaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" style="color: teal;">
                    <i class="bi bi-plus-circle me-2"></i>Nova Turma
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('turmas.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="modal-body row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Título do Evento</label>
                        <select name="id_evento" class="form-select" required>
                            <option value="" disabled selected>Escolha o evento...</option>
                            @foreach($eventos as $evento)
                                <option value="{{ $evento->id_evento }}">{{ $evento->nome_evento }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Local do Evento (Municípios do PA)</label>
                        <select name="local_oferta" class="form-select" required>
                            <option value="" disabled selected>Selecione o Município...</option>
                            @foreach($municipios as $municipio)
                                <option value="{{ $municipio['nome'] }}">{{ $municipio['nome'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Data de Início</label>
                        <input type="date" name="data_inicio" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Data de Término</label>
                        <input type="date" name="data_fim" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Quantidade Máxima de Participantes</label>
                        <input type="number" name="quantidade_maxima" class="form-control" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Descrição do Evento</label>
                        <textarea name="descricao" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-teal">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- MODAL DE EDITAR TURMA --}}
<div class="modal fade" id="modalEditarTurma" tabindex="-1" aria-labelledby="modalEditarTurmaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" style="color: teal;">
                    <i class="bi bi-pencil-square me-2"></i>Editar Turma
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('turmas.update', ['id' => $turma->id_turma]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Título do Evento</label>
                        <select name="id_evento" class="form-select">
                            <option value="" disabled>Selecione o evento...</option>
                            @foreach($eventos as $evento)
                                <option value="{{ $evento->id_evento }}">{{ $evento->nome_evento }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Local do Evento (Municípios do PA)</label>
                        <select name="local_oferta" class="form-select">
                            <option value="" disabled>Selecione o Município...</option>
                            @foreach($municipios as $municipio)
                                <option value="{{ $municipio['nome'] }}">{{ $municipio['nome'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Quantidade Máxima de Participantes</label>
                        <input type="number" name="quantidade_maxima" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Data de Início</label>
                        <input type="date" name="data_inicio" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Data de Término</label>
                        <input type="date" name="data_fim" class="form-control">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Descrição do Evento</label>
                        <textarea name="descricao" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-teal">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function () {
        $('form').on('submit', function (e) {
            var form = this;
            var botao = $(this).find('button[type="submit"], .btn-teal');


            if (botao.prop('disabled')) {
                e.preventDefault();
                return false;
            }

            botao.prop('disabled', true);
            botao.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Salvando...');


            e.preventDefault();
            setTimeout(function () {
                form.submit();
            }, 100);
        });

        $('.btn-editar-turma').on('click', function () {
            var linha = $(this).closest('tr');
            var idTurma = $(this).data('id'); // Garanta que o botão tenha data-id="{{ $turma->id_turma }}"
            var descricao = $(this).data('descricao'); 
            var idEvento = $(this).data('id-evento');
            var localOferta = $(this).data('local');
            var qtdMaxima = $(this).data('qtd-maxima');
            var dataInicio = $(this).data('data-inicio');
            var dataFim = $(this).data('data-fim');

            var modal = $('#modalEditarTurma');
            var form = modal.find('form');
            var urlUpdate = "{{ route('turmas.index') }}/" + idTurma;
            form.attr('action', urlUpdate);

            modal.find('select[name="id_evento"]').val(idEvento);
            modal.find('select[name="local_oferta"]').val(localOferta);
            modal.find('input[name="quantidade_maxima"]').val(qtdMaxima);
            modal.find('input[name="data_inicio"]').val(dataInicio);
            modal.find('input[name="data_fim"]').val(dataFim);
            modal.find('textarea[name="descricao"]').val(descricao);
        });

        $('#modalCadastrarTurma').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
        });
    });

    document.addEventListener('DOMContentLoaded', function (){
        setTimeout(function() {
            var alertElements = document.querySelectorAll('.alert-dismissible');
            alertElements.forEach(function(alertElement){
                if (alertElement) {
                    var bsAlert = new bootstrap.Alert(alertElement);
                    bsAlert.close()
                }
            });
        }, 5000);
    });
</script>
@endsection