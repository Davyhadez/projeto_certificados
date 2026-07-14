<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CertificadoController extends Controller
{
    public function emitirCertificado($id)
    {
        $dados = [
            'nome_completo'     => 'DAVID GABRIEL LAGO DE OLIVEIRA',
            'curso'             => 'FORMAÇÃO DE AGENTE DE FISCALIZAÇÃO',    
            'municipio'         => 'ANANINDEUA',
            'data_inicio'       => '10/11/2025',
            'data_fim'          => '11/12/2025',
            'carga_horaria'     => '80',
            'data_emissao'      => Carbon::now()->locale('pt-BR')->translatedFormat('d \d\e F \d\e Y'),
            'codigo_validacao'  => '1-2'
        ];

        $pdf = Pdf::loadView('auth.modelo', compact('dados'));

        $pdf->setOption(['isRemoteEnabled' => true]);
        $pdf->setpaper('a4', 'landscape');

        return $pdf->stream('certificado_' . strtolower(str_replace(' ', '_', $dados['nome_completo'])) . '.pdf');
    }
}

