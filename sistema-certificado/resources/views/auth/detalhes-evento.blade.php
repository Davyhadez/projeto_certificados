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
                                @foreach($evento->disciplinas as $disciplina)
                                <tr>
                                    <td>{{ $disciplina->nome_disciplina }}</td>
                                    <td class="text-center">{{ $disciplina->carga_horaria }}h</td>
                                    
                                    <td class="text-center">
                                        @if($disciplina->conteudo)
                                            {{-- Botão para abrir o Modal de Conteúdo --}}
                                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalConteudo{{ $disciplina->id_disciplina }}">
                                                <i class="bi bi-file-text"></i> Ver Conteúdo
                                            </button>
                                        @else
                                            <span class="text-muted small">Sem conteúdo</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group">
                                            {{-- Botão Editar (Abre modal ou redireciona) --}}
                                            <button class="btn btn-sm btn-outline-primary" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            {{-- Botão Excluir com confirmação simples --}}
                                            <form action="{{ route('disciplinas.destroy', $disciplina->id_disciplina) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta disciplina?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                                    <i class="bi bi-trash"></i>
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
                                @endforeach
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

<style>
    .text-teal { color: teal !important; }
    .btn-teal { background-color: teal !important; color: white; border: none; }
    .btn-teal:hover { background-color: #006666 !important; color: white; transform: translateY(-1px); }
    .form-control:focus { background-color: #fff !important; box-shadow: 0 0 0 0.25rem rgba(0, 128, 128, 0.1); border: 1px solid teal !important; }
</style>
@endsection
