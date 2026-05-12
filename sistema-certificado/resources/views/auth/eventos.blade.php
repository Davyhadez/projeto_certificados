@extends('auth.dashboard') {{-- Puxa o layout com a sidebar e header --}}

@section('conteudo') {{-- O nome do seu @yield lá na dashboard deve ser 'conteudo' --}}

<div class="card shadow-sm border-1 p-3">
    <div class="card shadow-sm border-0 p-1">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold mb-4 justify-content-start d-flex" style="color: #000;">
                <i class="bi bi-calendar-check me-2" style="color: #000;"></i>Consulta de Eventos
            </h2>

            <button type="button"
                class="btn-teal d-flex align-items-center"
                data-bs-toggle="modal"
                data-bs-target="#modalCadastrarEvento">
                <i class="bi bi-calendar-plus-fill me-2"></i>
                Cadastrar Evento
            </button>
        </div>

        <form action="{{ route('eventos.index') }}" method="GET">

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
                        <td class="text-center">
                            @if($evento->id_tipo_evento == 1)
                            {{-- Soma dinâmica para CURSOS --}}
                            <strong>{{ $evento->disciplinas->sum('carga_horaria') }}</strong> HORAS/AULA
                            @else
                            {{-- Valor fixo para PALESTRAS --}}
                            {{ $evento->carga_horaria }} HORAS/AULA
                            @endif
                        </td>
                        {{-- Localize esta TD na sua tabela de listagem --}}
                        <td class="text-center">
                            @if($evento->id_tipo_evento == 2)
                            {{-- Se for Palestra, não tem disciplinas --}}
                            <span class="badge bg-secondary badge-evento">
                                <i class="bi bi-dash-circle me-1"></i>Sem disciplinas
                            </span>
                            @else
                            {{-- PARA CURSOS: O botão de "Ver Disciplinas" --}}
                            <a href="{{ route('eventos.show', $evento->id_evento) }}" class="btn btn-sm btn-outline-secondary fw-bold btn-visualizar">
                                <i class="bi bi-eye-fill"></i>
                                Ver Disciplinas
                            </a>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border">
                                {{ $evento->tipo->descricao_tipo_evento }}
                            </span>
                        </td>
                        <td class="d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-primary btn-editar"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditarEvento"
                                data-id="{{ $evento->id_evento }}"
                                data-nome="{{ $evento->nome_evento }}"
                                data-tipo="{{ $evento->id_tipo_evento }}"
                                data-carga="{{ $evento->carga_horaria }}">

                                <i class="bi bi-pencil-square"></i>
                                Editar
                            </button>


                            <form action="{{ route('eventos.destroy', $evento->id_evento) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este evento?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-sm btn-outline-danger btn-deletar">
                                    <i class="bi bi-trash"></i>
                                    <span>Deletar</span>
                                </button>
                            </form>
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



{{-- MODAL DE EDITAR --}}
<div class="modal fade"
    id="modalEditarEvento"
    tabindex="-1"
    aria-labelledby="modalEditarEventoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" style="color: teal;">
                    <i class="bi bi-pencil-square me-2"></i>Editar Evento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="" method="POST" id="formEditarEvento">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nome_evento" class="form-label fw-bold">Nome do Evento</label>
                        <input type="text" name="nome_evento" id="edit_nome_evento" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_id_tipo_evento" class="form-label fw-bold">Tipo do Evento</label>
                        <select name="id_tipo_evento" id="edit_id_tipo_evento" class="form-select" required>
                            <option value="" disabled>Selecione o tipo</option>
                            @foreach($tipos as $tipo)
                            <option value="{{ $tipo->id_tipo_evento }}">{{ $tipo->descricao_tipo_evento }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" id="edit_container_carga_horaria">
                        <label for="edit_carga_horaria" class="form-label fw-bold">Carga Horária (Horas/Aula)</label>
                        <input type="number" name="carga_horaria" id="edit_carga_horaria" class="form-control" min="1">
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



{{-- MODAL DE CADASTRAR --}}
<div class="modal fade" id="modalCadastrarEvento"
    tabindex="-1"
    aria-labelledby="modalCadastrarEventoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" style="color: teal;">
                    <i class="bi bi-calendar-plus me-2"></i>Novo Evento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <form action="{{ route('eventos.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nome do Evento</label>
                        <input type="text" name="nome_evento" class="form-control" placeholder="Ex: Curso de Formação" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tipo do Evento</label>
                        <select name="id_tipo_evento" id="id_tipo_evento" class="form-select">
                            <option value="" disabled selected>Selecione o tipo</option>
                            @foreach($tipos as $tipo)
                            <option value="{{ $tipo->id_tipo_evento }}">{{ $tipo->descricao_tipo_evento }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3" id="container_carga_horaria">
                        <label class="form-label fw-bold">Carga Horária (Horas/Aula)</label>
                        <input type="number" id="carga_horaria" name="carga_horaria" class="form-control" placeholder="Ex: 40" min="1" required>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-teal">Salvar</button>
                </div>
            </form>


        </div>
    </div>
</div>

<script>
    // Função principal para esconder/exibir a carga horária
    function gerenciarCarga(selectEl, containerEl, inputEl) {
        if (!selectEl || !containerEl) return;
        
        const texto = selectEl.options[selectEl.selectedIndex].text.toUpperCase();
        if (texto.includes('CURSO')) {
            containerEl.style.display = 'none';
            inputEl.value = ''; // Limpa o valor se for curso
            inputEl.removeAttribute('required');
        } else {
            containerEl.style.display = 'block';
            inputEl.setAttribute('required', 'required');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // --- LÓGICA DO MODAL CADASTRAR ---
        const selectCad = document.getElementById('id_tipo_evento');
        const containerCad = document.getElementById('container_carga_horaria');
        const inputCad = document.getElementById('carga_horaria');

        if (selectCad) {
            selectCad.addEventListener('change', () => gerenciarCarga(selectCad, containerCad, inputCad));
        }

        // --- LÓGICA DO MODAL EDITAR ---
        const modalEditar = document.getElementById('modalEditarEvento');
        const selectEdit = document.getElementById('edit_id_tipo_evento');
        const containerEdit = document.getElementById('edit_container_carga_horaria');
        const inputEdit = document.getElementById('edit_carga_horaria');

        // Quando o modal de editar abrir
        modalEditar.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            
            // 1. Captura os dados do botão (Faltava capturar a carga aqui!)
            const id = button.getAttribute('data-id');
            const nome = button.getAttribute('data-nome');
            const tipo = button.getAttribute('data-tipo');
            const carga = button.getAttribute('data-carga'); // <--- CAPTURA O VALOR

            // 2. Preenche os campos básicos
            modalEditar.querySelector('#edit_nome_evento').value = nome;
            selectEdit.value = tipo;
            
            // 3. Define a rota de update
            modalEditar.querySelector('#formEditarEvento').action = '/eventos/' + id;

            gerenciarCarga(selectEdit, containerEdit, inputEdit);

            const texto = selectEdit.options[selectEdit.selectedIndex].text.toUpperCase();
            if (!texto.includes('CURSO')) {
                inputEdit.value = carga; 
            }
        });

        // Quando mudar o tipo dentro do modal de editar
        if (selectEdit) {
            selectEdit.addEventListener('change', () => gerenciarCarga(selectEdit, containerEdit, inputEdit));
        }
    });
</script>

@endsection