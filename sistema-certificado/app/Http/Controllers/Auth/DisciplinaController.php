<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\Disciplina;
use App\Http\Controllers\Controller;

class DisciplinaController extends Controller
{
    public function store(Request $request, $id_evento)
    {
        $request->validate([
            'nome_disciplina' => 'required|string|max:255',
            'carga_horaria' => 'required|numeric',
            'conteudo' => 'nullable|string',
        ]);

        Disciplina::create([
            'nome_disciplina' => $request->nome_disciplina,
            'carga_horaria' => $request->carga_horaria,
            'conteudo' => $request->conteudo,
            'id_evento' => $id_evento // O ID vem da URL
        ]);

        return redirect()->back()->with('success', 'Disciplina adicionada com sucesso!');
    }

    public function destroy($id)
    {
        $disciplina = Disciplina::findOrFail($id);
        
        $disciplina->delete();

        return redirect()->back()->with('success', 'Disciplina removida com sucesso!');
    }
}