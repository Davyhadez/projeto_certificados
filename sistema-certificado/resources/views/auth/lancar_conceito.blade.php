@extends('auth.dashboard') 

@section('voltarPessoas')
    <a href="{{ route('turmas.participantes', $turma->id_turma) }}"
        class="btn-teal-voltar">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
@endsection

@section('conteudo')

<form action="{{ route('turmas.salvar-aptidao', $turma->id_turma) }}" method="POST">
    @csrf

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="text-center">
                    <h4 class="fw-bold mb-1">Alunos da Turma ({{ $turma->alunos->count() }}/{{ $turma->quantidade_maxima }})</h4>
                    <p class="text-muted small mb-0">Marque os alunos que estão <strong>aptos</strong> e clique em Salvar Conceitos.</p>
                </div>
                <div style="width: 90px;"></div> 
            </div>

            <div class="row mb-3 justify-content-end">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" id="pesquisaAluno" class="form-control border-start-0" placeholder="Pesquisar por aluno...">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover border table-compacta align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="60%">Nome do Aluno</th>
                            <th width="40%" class="text-center">
                                <div class="form-check form-switch d-inline-block">
                                    <input class="form-check-input" type="checkbox" id="marcarTodos">
                                    <label class="form-check-label fw-bold text-dark" for="marcarTodos">Marcar Todos como Aptos</label>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($turma->alunos as $aluno)
                            @php
                                // Verifica se o conceito atual na tabela pivô é Apto
                                $isApto = Str::upper($aluno->pivot->conceito) === 'APTO';
                            @endphp
                            <tr>
                                <td>{{ $aluno->nome_pessoa }}</td>
                                <td class="text-center">
                                    <div class="form-check form-switch d-inline-block">
                                        <input class="form-check-input switch-aptidao" 
                                               type="checkbox" 
                                               id="aluno_{{ $aluno->id_pessoa }}" 
                                               name="alunos[{{ $aluno->id_pessoa }}][apto]" 
                                               value="1" 
                                               {{ $isApto ? 'checked' : '' }}>
                                        <label class="form-check-label {{ $isApto ? 'text-teal fw-bold' : 'text-muted' }} status-label" 
                                               for="aluno_{{ $aluno->id_pessoa }}">
                                            {{ $isApto ? 'Apto' : 'Inapto' }}
                                        </label>
                                    </div> {{-- CORRIGIDO: Tag de fechamento da div que estava faltando --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn-green-salvar shadow-sm">
                    <i class="bi bi-check-circle"></i> Salvar Conceitos
                </button>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const marcarTodosBtn = document.getElementById('marcarTodos');
    const switchesAluno = document.querySelectorAll('.switch-aptidao');
    const campoPesquisa = document.getElementById('pesquisaAluno');

    function atualizarLabel(checkbox) {
        const label = checkbox.closest('.form-check').querySelector('.status-label');
        if (checkbox.checked) {
            label.textContent = 'Apto';
            label.classList.add('text-teal', 'fw-bold');
            label.classList.remove('text-muted');
        } else {
            label.textContent = 'Inapto';
            label.classList.remove('text-teal', 'fw-bold');
            label.classList.add('text-muted');
        }
    }

    switchesAluno.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            atualizarLabel(this);
            if (!this.checked) {
                marcarTodosBtn.checked = false;
            }
        });
    });

    marcarTodosBtn.addEventListener('change', function () {
        const estaMarcado = this.checked;
        switchesAluno.forEach(checkbox => {
            const linha = checkbox.closest('tr');
            if (linha.style.display !== 'none') {
                checkbox.checked = estaMarcado;
                atualizarLabel(checkbox);
            }
        });
    });

    campoPesquisa.addEventListener('keyup', function () {
        const termoBusca = this.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        switchesAluno.forEach(checkbox => {
            const linha = checkbox.closest('tr');
            const nomeAluno = linha.querySelector('td:first-child').textContent
                                   .toLowerCase()
                                   .normalize("NFD")
                                   .replace(/[\u0300-\u036f]/g, "");

            if (nomeAluno.includes(termoBusca)) {
                linha.style.display = '';
            } else {
                linha.style.display = 'none';
            }
        });
    });
});
</script>
@endsection