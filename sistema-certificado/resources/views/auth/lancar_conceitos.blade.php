@extends('layouts.app') 

@section('content')
<div class="container mt-4" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05); max-width: 900px;">
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('turmas.participantes', $turma->id_turma) }}" class="btn btn-light border">Voltar</a>
        <h3 class="text-center" style="margin: 0; flex-grow: 1; font-weight: bold;">Alunos ({{ $turma->alunos->count() }}/10):</h3>
    </div>
    
    <p class="text-center text-muted">Marque os alunos que estão <strong>aptos</strong> e clique em <strong>Salvar Conceitos</strong>.</p>

    <form action="{{ route('turmas.conceitos.salvar', $turma->id_turma) }}" method="POST">
        @csrf
        <table class="table table-bordered align-middle mt-4">
            <thead class="table-light">
                <tr>
                    <th>Nome</th>
                    <th width="280">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="marcarTodos">
                            <label class="form-check-label font-weight-bold" for="marcarTodos"><strong>Marcar/desmarcar todos</strong></label>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($turma->alunos as $aluno)
                    <tr>
                        <td>{{ $aluno->nome_pessoa }}</td>
                        <td>
                            <div class="form-check form-switch">
                                {{-- O name="aptos[]" vai enviar um array para o Laravel contendo apenas os IDs dos marcados --}}
                                <input class="form-check-input checkbox-aluno" type="checkbox" name="aptos[]" value="{{ $aluno->id_pessoa }}" id="aluno_{{ $aluno->id_pessoa }}"
                                    {{ $aluno->pivot->conceito == 'APTO' ? 'checked' : '' }}>
                                <label class="form-check-label" for="aluno_{{ $aluno->id_pessoa }}">Apto</label>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <button type="submit" class="btn btn-success w-100" style="background-color: #1b5e20; border: none; padding: 12px; font-weight: bold;">
                Salvar conceitos
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('marcarTodos').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('.checkbox-aluno');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
@endsection