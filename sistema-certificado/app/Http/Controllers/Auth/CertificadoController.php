<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pessoa;
use App\Models\Turma;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CertificadoController extends Controller
{
    public function emitirCertificado(Request $request, $id)
    {
        // Busca a pessoa pelo id
        $pessoa = Pessoa::findOrFail($id);

        // Busca a turma com o evento
        $id_turma = $request->query('turma');
        $tipo     = $request->query('tipo', 'aluno'); // 'aluno' ou 'instrutor'

        $turma = Turma::with(['evento', 'evento.disciplinas'])->findOrFail($id_turma);

        // Calcula a carga horária
        if ($turma->evento && $turma->evento->id_tipo_evento == 1) {
            $cargaHoraria = $turma->evento->disciplinas->sum('carga_horaria');
        } else {
            $cargaHoraria = $turma->evento->carga_horaria ?? 0;
        }

        // Texto de participação conforme o tipo
        $tipoParticipacao = ($tipo === 'instrutor') ? 'instrutor' : 'instruído';

        $dados = [
            'nome_completo'     => strtoupper($pessoa->nome_pessoa),
            'curso'             => strtoupper($turma->evento->nome_evento ?? 'N/A'),
            'municipio'         => strtoupper($turma->local_oferta ?? 'N/A'),
            'data_inicio'       => $turma->data_inicio
                                    ? Carbon::parse($turma->data_inicio)->format('d/m/Y')
                                    : 'N/A',
            'data_fim'          => $turma->data_fim
                                    ? Carbon::parse($turma->data_fim)->format('d/m/Y')
                                    : 'N/A',
            'carga_horaria'     => $cargaHoraria,
            'data_emissao'      => Carbon::now()->locale('pt-BR')->translatedFormat('d \d\e F \d\e Y'),
            'codigo_validacao'  => $id . '-' . $id_turma,
            'tipo_participacao' => $tipoParticipacao,
            'disciplinas'       => $turma->evento->disciplinas ?? collect(),
        ];

        $pdf = Pdf::loadView('auth.modelo', compact('dados'));

        $pdf->setOption(['isRemoteEnabled' => true]);
        $pdf->setpaper('a4', 'landscape');

        $nomeArquivo = 'certificado_' . strtolower(str_replace(' ', '_', $pessoa->nome_pessoa)) . '.pdf';

        return $pdf->stream($nomeArquivo);
    }
}
