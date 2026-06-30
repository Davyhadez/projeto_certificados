<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Turma;

class AssinaturaController extends Controller
{
    private function checkAccess()
    {
        if (!auth()->check() || (int)auth()->user()->id_tipo_usuario !== 3) {
            return redirect()->route('dashboard')->with('error', 'Acesso negado: apenas usuários do tipo Gabinete podem acessar esta página.');
        }
        return null;
    }

    public function index()
    {
        if ($redirect = $this->checkAccess()) {
            return $redirect;
        }

        $turmas = Turma::with('evento')->withCount('alunos')->get();
        return view('auth.assinatura', compact('turmas'));
    }


    public function store(Request $request)
    {
        if ($redirect = $this->checkAccess()) {
            return $redirect;
        }

        return redirect()->route('assinaturas.index')->with('success', 'Assinatura criada com sucesso!');
    }


    public function update(Request $request, $id)
    {
        if ($redirect = $this->checkAccess()) {
            return $redirect;
        }

        $turma = Turma::findOrFail($id);

        if (in_array((int)$turma->id_situacao_turma, [3, 4])) {
            $turma->id_situacao_turma = 2;
            $turma->certificado_liberado = 1;
            $turma->data_liberacao_certificado = now()->format('Y-m-d');
            $turma->save();
            return redirect()->route('assinaturas.index')->with('success', 'Assinatura liberada e certificados disponíveis para emissão!');
        }

        return redirect()->route('assinaturas.index')->with('error', 'Não foi possível alterar a situação desta turma.');
    }


    public function destroy($id)
    {
        if ($redirect = $this->checkAccess()) {
            return $redirect;
        }

        return redirect()->route('assinaturas.index')->with('success', 'Assinatura excluída com sucesso!');
    }
}