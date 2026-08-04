<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pessoa;
use App\Models\Inscricao;
use App\Models\Turma;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CertificadoController extends Controller
{
    /**
     * Exibe a página pública de consulta de certificados.
     */
    public function index()
    {
        return view('auth.consultarCertificados');
    }

    public function consultar(Request $request)
    {
        $request->validate([
            'cpf' => 'required|string',
            'data_nascimento' => 'required|date',
        ], [
            'cpf.required' => 'O CPF é obrigatório.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
        ]);

        $cpfLimpo = preg_replace('/[^0-9]/', '', $request->cpf);
        $cpfFormatado = strlen($cpfLimpo) === 11 
            ? preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpfLimpo)
            : $request->cpf;

        $pessoa = Pessoa::where(function ($query) use ($cpfLimpo, $cpfFormatado) {
                $query->where('cpf', $cpfLimpo)
                      ->orWhere('cpf', $cpfFormatado);
            })
            ->whereDate('data_nascimento', $request->data_nascimento)
            ->first();

        if (!$pessoa) {
            return back()->withErrors(['msg' => 'Nenhum registro encontrado para os dados informados.'])->withInput();
        }

        $certificados = Inscricao::with(['turma.evento'])
            ->where('id_pessoa', $pessoa->id_pessoa)
            ->get();

        return view('auth.consultarCertificados', compact('pessoa', 'certificados'));
    }

    
    public function emitirCertificado(Request $request, $id)
    {
        $pessoa = Pessoa::where('id_pessoa', $id)->firstOrFail();

        $id_turma = $request->query('turma');
        $tipo     = $request->query('tipo', 'aluno');

        $turma = Turma::with(['evento', 'evento.disciplinas'])->where('id_turma', $id_turma)->firstOrFail();

        if ($turma->evento && $turma->evento->id_tipo_evento == 1) {
            $cargaHoraria = $turma->evento->disciplinas->sum('carga_horaria');
        } else {
            $cargaHoraria = $turma->evento->carga_horaria ?? 0;
        }

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
        $pdf->setPaper('a4', 'landscape');

        $nomeArquivo = 'certificado_' . strtolower(str_replace(' ', '_', $pessoa->nome_pessoa)) . '.pdf';

        return $pdf->stream($nomeArquivo);
    }
}