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
                        <span class="fs-4 fw-bold">{{ $evento->carga_horaria }}h</span>
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
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nome da Disciplina</th>
                                    <th class="text-center">Carga Horária</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($evento->disciplinas as $disciplina)
                                    <tr>
                                        <td class="ps-4 fw-semibold text-uppercase" style="font-size: 0.9rem;">
                                            {{ $disciplina->nome_disciplina }}
                                        </td>
                                        <td class="text-center">{{ $disciplina->carga_horaria }}h</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-danger border-0">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="85" class="opacity-25 mb-3">
                                            <p class="text-muted">Nenhuma disciplina vinculada a este evento.</p>
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
                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">NOME DA DISCIPLINA</label>
                            <input type="text" class="form-control bg-light border-0" placeholder="Ex: Legislação de Trânsito" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">CARGA HORÁRIA (HORAS)</label>
                            <input type="number" class="form-control bg-light border-0" placeholder="00" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">CONTEÚDO PROGRAMÁTICO</label>
                            <textarea class="form-control bg-light border-0" rows="4" placeholder="Descreva os tópicos..."></textarea>
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
