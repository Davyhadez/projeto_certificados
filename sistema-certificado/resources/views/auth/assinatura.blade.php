@extends('auth.dashboard')


@section('conteudo')
    <div class="card shadow-sm border-1 p-4">

        <h2 class="mb-4"><i class="bi bi-file-earmark-text"> </i>Assinaturas</h2>

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

        <div class="table-responsive mb-4">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-light">
                    <tr class="text-uppercase" style="font-size: 0.9rem;">
                        <th scope="col" class="text-center" style="width: 20%;">Evento</th>
                        <th scope="col" class="text-center" style="width: 5%;">Status</th>
                        <th scope="col" class="text-center" style="width: 5%;">Local</th>
                        <th scope="col" class="text-center" style="width: 12%;">Total de Alunos</th>
                        <th scope="col" class="text-center" style="width: 10%;">Carga Horária</th>
                        <th scope="col" class="text-center" style="width: 15%;">Período (Início/Fim)</th>
                        <th scope="col" class="text-center" style="width: 13%;">Data de Registro</th>
                        <th scope="col" class="text-center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @if($turmas->count() > 0)
                        @foreach($turmas as $turma)
                        <tr>
                            <td class="none">{{ $turma->evento->nome_evento ?? 'Evento não encontrado' }}</td>
                            <td class="text-center">
                                @if((int)$turma->id_situacao_turma === 1)
                                    <span class="badge bg-warning text-dark text-uppercase" style="font-size: 0.8rem; padding: 5px 10px;">Aberta</span>
                                @elseif((int)$turma->id_situacao_turma === 2)
                                    <span class="badge bg-success text-uppercase" style="font-size: 0.8rem; padding: 5px 10px;">Liberado</span>
                                @elseif((int)$turma->id_situacao_turma === 3)
                                    <span class="badge text-uppercase" style="font-size: 0.8rem; padding: 5px 10px; background-color: #fd7e14; color: white;">Pendente</span>
                                @elseif((int)$turma->id_situacao_turma === 4)
                                    <span class="badge bg-secondary text-uppercase" style="font-size: 0.8rem; padding: 5px 10px;">Fechada</span>
                                @else
                                    <span class="badge bg-dark text-uppercase" style="font-size: 0.8rem; padding: 5px 10px;">N/A</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $turma->local_oferta ?? 'N/A' }}</td>
                            <td class="text-center fw-bold">{{ $turma->alunos_count ?? 0 }}/{{ $turma->quantidade_maxima }}</td>
                            <td class="text-center">
                                @if($turma->evento && $turma->evento->id_tipo_evento == 1)
                                <strong>{{ $turma->evento->disciplinas->sum('carga_horaria') }}</strong> HORAS/AULA
                                @elseif($turma->evento)
                                {{-- Valor fixo para PALESTRAS --}}
                                {{ $turma->evento->carga_horaria }} HORAS/AULA
                                @else
                                N/A
                                @endif
                            </td>
                            <td class="text-center">
                                {{ $turma->data_inicio ? \Carbon\Carbon::parse($turma->data_inicio)->format('d/m/Y') : 'N/A' }} -
                                {{ $turma->data_fim ? \Carbon\Carbon::parse($turma->data_fim)->format('d/m/Y') : 'N/A' }}
                            </td>
                            <td class="text-center">
                                {{ $turma->data_registro ? \Carbon\Carbon::parse($turma->data_registro)->format('d/m/Y') : 'N/A' }}
                            </td>
                            <td class="text-center">
                                @if((int)$turma->id_situacao_turma === 1)
                                    {{-- Aberta: Aguardando Conceitos --}}
                                    <button class="btn btn-sm btn-outline-warning d-flex align-items-center gap-1 justify-content-center w-100" disabled title="A turma precisa ter os conceitos lançados primeiro.">
                                        <i class="bi bi-hourglass-split"></i> Aguardando Conceitos
                                    </button>
                                @elseif((int)$turma->id_situacao_turma === 4 || (int)$turma->id_situacao_turma === 3)
                                    {{-- Fechada ou Pendente: Liberar Assinatura --}}
                                    <button type="button" class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1 justify-content-center w-100 btn-liberar-assinatura" data-id="{{ $turma->id_turma }}" data-nome="{{ $turma->evento->nome_evento ?? 'Evento' }}">
                                        <i class="bi bi-pencil-square"></i> Liberar Assinatura
                                    </button>
                                @elseif((int)$turma->id_situacao_turma === 2)
                                    {{-- Liberada: Liberada --}}
                                    <button class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 justify-content-center w-100" disabled>
                                        <i class="bi bi-check-circle-fill"></i> Liberada
                                    </button>
                                @else
                                    <button class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 justify-content-center w-100" disabled>
                                        N/A
                                    </button>
                                @endif
                            </td>
                        </tr>                   
                        @endforeach
                    @else
                    <tr>
                        <td colspan="8" class="text-center text-muted">Nenhuma turma encontrada</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Confirmação Dinâmico -->
    <div class="modal fade" id="confirmarModal" tabindex="-1" aria-labelledby="confirmarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom border-light p-4">
                    <h5 class="modal-title fw-bold text-slate-800" id="confirmarModalLabel">Confirmar Ação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-5">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border" style="width: 80px; height: 80px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; background-color: #f0f8ff;">
                        <i id="confirmarIcon" class="bi bi-question-circle text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <p id="confirmarTexto" class="mt-3 fs-5 text-secondary"></p>
                </div>
                <div class="modal-footer border-top border-light p-4 justify-content-center">
                    <button type="button" class="btn btn-secondary px-4 me-2" data-bs-dismiss="modal">Não</button>
                    <form id="formConfirmar" action="" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success px-4">Sim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto close alerts
            setTimeout(function() {
                var alertElements = document.querySelectorAll('.alert-dismissible');
                alertElements.forEach(function(alertElement){
                    if (alertElement) {
                        var bsAlert = new bootstrap.Alert(alertElement);
                        bsAlert.close();
                    }
                });
            }, 5000);

            // Modal confirmation logic
            const btnLiberar = document.querySelectorAll('.btn-liberar-assinatura');
            const modal = new bootstrap.Modal(document.getElementById('confirmarModal'));
            const form = document.getElementById('formConfirmar');
            const texto = document.getElementById('confirmarTexto');
            const titulo = document.getElementById('confirmarModalLabel');
            const icon = document.getElementById('confirmarIcon');

            btnLiberar.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const nome = this.getAttribute('data-nome');
                    form.action = `{{ url('assinaturas') }}/${id}`;
                    titulo.textContent = 'Confirmar Liberação de Assinatura';
                    texto.innerHTML = `Deseja realmente liberar a assinatura dos certificados para a turma do evento <strong>${nome}</strong>?`;
                    icon.className = 'bi bi-pencil-square text-primary';
                    icon.parentElement.style.backgroundColor = '#e6f7ff';
                    icon.parentElement.style.borderColor = '#91d5ff';
                    modal.show();
                });
            });

            // Prevent double submits
            $('#formConfirmar').on('submit', function() {
                var botao = $(this).find('button[type="submit"]');
                botao.prop('disabled', true);
                botao.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Salvando...');
            });
        });
    </script>
@endsection
