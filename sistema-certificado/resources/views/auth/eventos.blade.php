@extends('auth.dashboard') {{-- Puxa o layout com a sidebar e header --}}

@section('conteudo') {{-- O nome do seu @yield lá na dashboard deve ser 'conteudo' --}}

<style>
    .btn-teal {
        transition: all 0.3s ease;
    }
    .btn-teal:hover {
        background-color: #004d40 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .table thead th {
        background-color: #f8f9fa;
        color: #333;
        font-weight: 700;
    }
    /* Ajuste para o ícone de ação */
    .col-acoes {
        width: 120px;
    }
</style>

<div class="card shadow-sm border-1 p-3">
    <div class="card shadow-sm border-0 p-1">
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold mb-4 justify-content-start d-flex" style="color: #000;">
                <i class="bi bi-calendar-check me-2" style="color: #000;"></i>Consulta de Eventos
            </h2>
            
            <a href="#" class="btn-teal d-flex align-items-center" 
               style="padding: 9px 9px; margin-top: 30px; background-color: teal; color: white; border-radius: 5px; text-decoration: none; font-weight: bold;">
                <i class="bi bi-calendar-plus-fill me-2"></i>
                Cadastrar Evento
            </a>
        </div>

        <form action="{{ route('pessoas.index') }}" method="GET">

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

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle m-0">
                <thead class="table-light">
                    <tr class="text-uppercase" style="font-size: 0.9rem;">
                        <th scope="col" style="width: 40%;">Nome</th>
                        <th scope="col" class="text-center">Carga horária</th>
                        <th scope="col" class="text-center">Disciplinas</th>
                        <th scope="col" class="text-center">Tipo Evento</th>
                        <th scope="col" class="text-center col-acoes">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($eventos as $evento)
                    <tr>
                        <td class="none">{{ $evento->nome_evento }}</td>
                        <td class="text-center">{{ $evento->carga_horaria }} HORAS/AULA</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-outline-primary fw-bold">
                                <i class="bi bi-eye-fill"></i>
                                Ver Disciplinas ({{ $evento->disciplinas_count }})
                            </a>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border">{{ $evento->tipo->id_tipo_evento == 1 ? 'CURSO' : ($evento->tipo->id_tipo_evento == 2 ? 'PALESTRA' : 'OUTRO') }}</span>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary btn-editar"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditarEvento"
                                        data-id="{{ $evento->id_evento }}"
                                        data-nome="{{ $evento->nome_evento }}"
                                        data-tipo="{{ $evento->id_tipo_evento }}">
                                <i class="bi bi-pencil-square"></i>
                                Editar
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Nenhum evento encontrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3 text-muted" style="font-size: 0.85rem;">
            <div>
                Total de eventos: <span class="fw-bold">{{ $eventos->total() }}</span>
            </div>
            <div>
                {{ $eventos->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarEvento" tabindex="-1" aria-labelledby="modalEditarEventoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="modalEditarEventoLabel">Editar Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="formEditarEvento" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nome_evento" class="form-label fw-bold">Nome do Evento</label>
                        <input type="text" class="form-control" id="edit_nome_evento" name="nome_evento" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_id_tipo_evento" class="form-label fw-bold">Tipo do Evento</label>
                        <select class="form-select" id="edit_id_tipo_evento" name="id_tipo_evento" required>
                            <option value="" disabled selected>Selecione o tipo</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo->id_tipo_evento }}">{{ $tipo->descricao_tipo_evento }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success px-4">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const modalEditar = document.getElementById('modalEditarEvento');
    modalEditar.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        
        // Pega os dados dos atributos data- que colocamos no botão
        const id = button.getAttribute('data-id');
        const nome = button.getAttribute('data-nome');
        const tipo = button.getAttribute('data-tipo');

        // Preenche os inputs do modal
        modalEditar.querySelector('#edit_nome_evento').value = nome;
        modalEditar.querySelector('#edit_id_tipo_evento').value = tipo;
        
        // Define a URL de destino do formulário
        // Usamos a rota nomeada ou o caminho absoluto para evitar o 404
        const form = modalEditar.querySelector('#formEditarEvento');
        form.action = '/eventos/' + id; 
    });
</script>

@endsection
