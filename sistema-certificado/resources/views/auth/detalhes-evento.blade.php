@extends ('auth.dashboard')

@section('conteudo')

    @section('voltarPessoas')
        <a href="{{ route('eventos.index') }}"
        class="btn-teal-voltar">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    @endsection
<div class="container-fluid pb-4">
    <div class="card border-0 shadow-sm mb-4" style="border-left: 5px solid !important;">
        <div class="card-body">
            <h3 class="fw-bold mb-0" style="color: #333;">
                <i class="bi bi-journal-text me-2"></i>
                Evento: <span class="text-muted">{{ $evento->nome_evento }}</span>
            </h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4 bg-light">
                <div class="card-body d-flex justify-content-around text-center">
                    <div>
                        <small class="text-muted d-block text-uppercase fw-bold">Carga Total</small>
                        <span class="fs-4 fw-bold">{{ $cargaTotal }}h</span>
                    </div>
                    <div class="border-start ps-4">
                        <small class="text-muted d-block text-uppercase fw-bold">Disciplinas</small>
                        <span class="fs-4 fw-bold">{{ $evento->disciplinas_count }}</span>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-list-check me-2"></i>Disciplinas Cadastradas</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>Nome da Disciplina</th>
                                    <th class="text-center">Carga Horária</th>
                                    <th class="text-center">Conteúdo</th> {{-- Nova Coluna --}}
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($evento->disciplinas as $disciplina)
                                <tr>
                                    <td>{{ $disciplina->nome_disciplina }}</td>
                                    <td class="text-center">{{ $disciplina->carga_horaria }}h</td>
                                    
                                    <td class="text-center">
                                        @if($disciplina->conteudo)
                                            <button type="button" class="btn btn-sm btn-outline-secondary btn-visualizar" data-bs-toggle="modal" data-bs-target="#modalConteudo{{ $disciplina->id_disciplina }}">
                                                <i class="bi bi-file-text"></i> Ver Conteúdo
                                            </button>
                                        @else
                                            <span class="text-muted small">Sem conteúdo</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2" role="group">
                                            <button type="button"
                                                class="btn btn-sm btn-outline-primary btn-editar"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditarPrincipal"
                                                data-id="{{ $disciplina -> id_disciplina }}"
                                                data-nome="{{ $disciplina -> nome_disciplina }}"
                                                data-carga_horaria="{{ $disciplina -> carga_horaria }}"
                                                data-conteudo="{{ $disciplina -> conteudo }}"
                                                data-id_evento="{{ $disciplina -> id_evento }}">
                                                <i class="bi bi-pencil-square"></i>
                                                <span>Editar</span>
                                            </button>

                                            <form action="{{ route('disciplinas.destroy', $disciplina->id_disciplina) }}"
                                                method="POST" 
                                                onsubmit="return confirm('Tem certeza que deseja excluir esta disciplina?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-2 btn-deletar" >
                                                    <i class="bi bi-trash"></i>
                                                    <span>Deletar</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal Dinâmico para cada Disciplina --}}
                                <div class="modal fade" id="modalConteudo{{ $disciplina->id_disciplina }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Conteúdo: {{ $disciplina->nome_disciplina }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-start">
                                                {{ $disciplina->conteudo }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                {{-- CAIXA DE LISTA VAZIA --}}
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-archive fs-1 d-block mb-2"></i>
                                            <p class="mb-0 fw-bold">Nenhuma disciplina cadastrada.</p>
                                            <small>As disciplinas adicionadas aparecerão aqui.</small>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>   
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i>Nova Disciplina</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('disciplinas.store', $evento->id_evento) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">NOME DA DISCIPLINA</label>
                            <input type="text" name="nome_disciplina" class="form-control bg-light border-0" placeholder="Ex: Legislação de Trânsito" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">CARGA HORÁRIA (HORAS)</label>
                            <input type="number" name="carga_horaria" class="form-control bg-light border-0" placeholder="00" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">CONTEÚDO PROGRAMÁTICO</label>
                            <textarea name="conteudo" class="form-control bg-light border-0" rows="4" placeholder="Descreva os tópicos..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-teal w-100 py-2 fw-bold text-uppercase shadow-sm">
                            Adicionar Disciplina
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEditarPrincipal" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarLabel">Editar Disciplina</h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>
            </div>
            <form action="" method="POST" id="formEditarDisciplina">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id_evento" id="edit_id_evento">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nome da Disciplina</label>
                        <input type="text" name="nome_disciplina" id="edit_nome_disciplina" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Carga Horária</label>
                        <input type="number" name="carga_horaria" id="edit_carga_horaria" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Conteúdo Programático</label>
                        <textarea name="conteudo" id="edit_conteudo" class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-teal" style="background-color: teal; color: white;">Atualizar Evento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEditar = document.getElementById('modalEditarPrincipal');
        
        if (modalEditar) {
            modalEditar.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                const id = button.getAttribute('data-id');
                const nome = button.getAttribute('data-nome');
                const carga = button.getAttribute('data-carga_horaria');
                const conteudo = button.getAttribute('data-conteudo');
                const id_evento = button.getAttribute('data-id_evento');

                const form = modalEditar.querySelector('form');
                form.action = `/disciplinas/${id}`;

                modalEditar.querySelector('#edit_nome_disciplina').value = nome;
                modalEditar.querySelector('#edit_carga_horaria').value = carga;
                modalEditar.querySelector('#edit_conteudo').value = conteudo;
                modalEditar.querySelector('#edit_id_evento').value = id_evento;

                console.log('Form action definido para: ' + form.action);

            });
        }
    });
</script>
@endsection
