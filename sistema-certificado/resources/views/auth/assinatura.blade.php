@extends('auth.dashboard')


@section('conteudo')
    <div class="card shadow-sm border-1 p-4">

        <h2 class="mb-4"><i class="bi bi-file-earmark-text"> </i>Assinaturas</h2>

        <!-- TABELA DE EVENTOS -->
        <div class="table-responsive mb-4">
            <table class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>EVENTO</th>
                        <th>STATUS</th>
                        <th>LOCAL</th>
                        <th>TOTAL DE ALUNOS</th>
                        <th>PERÍODO (INÍCIO/FIM)</th>
                        <th>DATA DE REGISTRO</th>
                        <th class="text-center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>evento</td>
                        <td>Liberado</td>
                        <td>Ananindeua</td>
                        <td>05/10</td>
                        <td>10/11/2025 - 09/12/2025</td>
                        <td>28/10/2025</td>
                        <td>
                            <a href=""
                                class="btn btn-outline-primary d-flex justify-content-center">
                                <i class="bi bi-pencil-square"></i>Liberar Assinatura
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
