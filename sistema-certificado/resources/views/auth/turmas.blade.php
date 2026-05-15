@extends('auth.dashboard')

@section('conteudo')

<div class="card shadow-sm border-1 p-3">
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

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle m-0">
                <thead class="table-light">
                    <tr class="text-uppercase" style="font-size: 0.9rem;">
                        <th scope="col" style="width: 30%;">Evento/Curso</th>
                        <th scope="col" class="text-center" style="width: 12%;">Status</th>
                        <th scope="col" class="text-center" style="width: 15%;">Local</th>
                        <th scope="col" class="text-center" style="width: 10%;">Alunos</th>
                        <th scope="col" class="text-center" style="width: 13%;">Carga Horária</th>
                        <th scope="col" class="text-center" style="width: 20%;">Período (Início/Fim)</th>
                        <th scope="col" class="text-center col-acoes">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="none">Agente de Fiscalização de Trânsito</td>
                        <td class="text-center">
                            <span class="badge bg-success text-uppercase" style="font-size: 0.8rem; padding: 5px 10px;">Liberado</span>
                        </td>
                        <td class="text-center">Ananindeua</td>
                        <td class="text-center fw-bold">32</td>
                        <td class="text-center">40 HORAS/AULA</td>
                        <td class="text-center">10/11/2025 - 09/12/2025</td>
                        <td class="d-flex justify-content-center gap-2">
                            <a href="#" class="btn btn-sm btn-outline-secondary fw-bold btn-visualizar" title="Ver Alunos">
                                <i class="bi bi-people-fill"></i>
                            </a>

                            <button type="button" class="btn btn-primary btn-editar"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditarTurma">
                                <i class="bi bi-pencil-square"></i>
                                Editar
                            </button>

                            <form action="#" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta turma?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger btn-deletar">
                                    <i class="bi bi-trash"></i>
                                    <span>Deletar</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Nenhuma turma encontrada.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3 text-muted" style="font-size: 0.85rem;">
            <div>
                Total de turmas: <span class="fw-bold">1</span>
            </div>
            <div>
                {{-- Espaço para os links de paginação do Laravel futuramente --}}
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
            
            <form action="#" method="POST" autocomplete="off">
                @csrf
                <div class="modal-body row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Selecione o Evento/Curso</label>
                        <select name="id_evento" class="form-select" required>
                            <option value="" disabled selected>Escolha o evento...</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Local da Turma</label>
                        <input type="text" name="local_turma" class="form-control" placeholder="Ex: Auditório Principal, Ananindeua" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status Inicial</label>
                        <select name="status_turma" class="form-select" required>
                            <option value="Liberado">Liberado</option>
                            <option value="Bloqueado">Bloqueado</option>
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
            
            <form action="#" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Evento/Curso</label>
                        <select name="id_evento" class="form-select" required>
                            <option value="" disabled>Selecione o evento...</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Local da Turma</label>
                        <input type="text" name="local_turma" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status_turma" class="form-select" required>
                            <option value="Liberado">Liberado</option>
                            <option value="Bloqueado">Bloqueado</option>
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
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-teal">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection