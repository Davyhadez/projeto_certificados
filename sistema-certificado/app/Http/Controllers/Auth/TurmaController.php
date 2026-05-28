<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Turma;
use App\Models\SituacaoTurma;
use App\Models\Pessoa;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class TurmaController extends Controller
{
    public function index(Request $request)
    {
        $eventos = Evento::all();

        $turmas = Turma::with('evento')->withCount('alunos')->get();

        $response = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/estados/15/municipios?orderBy=nome');

        $municipios = $response->successful() ? $response->json() : [];

        return view('auth.turmas', compact('eventos', 'municipios', 'turmas'));

    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'descricao'         => 'required|string|max:255',
            'data_inicio'       => 'required|date',
            'data_fim'          => 'required|date|after_or_equal:data_inicio',
            'local_oferta'      => 'required|string|max:255',
            'quantidade_maxima' => 'required|integer|min:1',
            'id_evento'         => 'required|exists:evento,id_evento',
        ]);

        $validatedData['id_usuario'] = Auth::id();

        $situacao = SituacaoTurma::where('descricao_situacao_turma', 'TURMA ABERTA')->first();

        $validatedData['id_situacao_turma'] = $situacao ? $situacao->id_situacao_turma : 1;

        $validateData['data_registro'] = now()->format('Y-m-d');

        Turma::create($validatedData);

        return redirect()->route('turmas.index')->with('success', 'Turma criada com sucesso!');
    }



    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'descricao'         => 'required|string|max:255',
            'data_inicio'       => 'required|date',
            'data_fim'          => 'required|date|after_or_equal:data_inicio',
            'local_oferta'      => 'required|string|max:255',
            'quantidade_maxima' => 'required|integer|min:1',
            'id_evento'         => 'required|exists:evento,id_evento',
        ]);

        $turma = \App\Models\Turma::findOrFail($id);
                
        $turma->update($validatedData);

        return redirect()->route('turmas.index')->with('success', 'Turma atualizada com sucesso!');
    }


    
    public function participantes($id)
    { 
        $turma = Turma::with(['evento', 'instrutores', 'alunos'])->findOrFail($id);

        $instrutoresDisponiveis = Pessoa::orderBy('nome_pessoa', 'asc')->get();     

        return view('auth.participantes', compact('turma', 'instrutoresDisponiveis'));        
    }



    public function show($id)
    {
        dd("Entrou na rota CORRETA (show) com ID: " . $id);

        $turma = Turma::with(['evento', 'instrutores', 'alunos'])->findOrfail($id);

        $instrutoresDisponiveis = Pessoa::where('tipo', 'instrutor')->get();

        return view('auth.participantes', compact('turma', 'instrutoresDisponiveis'));
    }



    public function vincularInstrutor(Request $request, $id)
    {
        $request->validate([
            'id_pessoa' => 'required|exists:pessoa,id_pessoa',
        ]);

        $turma = Turma::findOrFAil($id);

        $turma->instrutores()->syncWithoutDetaching([$request->id_pessoa]);

        return redirect()->back()->with('success', 'Instrutor adicionado com sucesso!');
    }



    public function vincularAluno(Request $request, $id)
    {
        $request->validate([
            'id_pessoa' => 'required|exists:pessoa,id_pessoa',
        ]);

        $turma = Turma::findOrFAil($id);

        $turma->alunos()->syncWithoutDetaching([$request->id_pessoa]);

        return redirect()->back()->with('success', 'Aluno adicionado com sucesso!');
    }



    public function destroy($id)
    {
        $turma = \App\Models\Turma::findOrFail($id);
        $turma->delete();

        return redirect()->route('turmas.index')->with('success', 'Turma excluída com sucesso!');
    }

    public function removerAluno($id_turma, $id_pessoa)
    {

        $turma = Turma::findOrFail($id_turma);

        $turma->alunos()->detach($id_pessoa);

        return redirect()->back()->with('success', 'Aluno removido com sucesso!');
    }



    public function removerInstrutor($id_turma, $id_pessoa)
    {

        $turma = Turma::findOrFail($id_turma);

        $turma->instrutores()->detach($id_pessoa);

        return redirect()->back()->with('success', 'Instrutor removido com sucesso!');
    }



    public function fecharTurma($id)
    {
        $turma = Turma::findOrFail($id);

            $turma->id_situacao_turma = 2; 
            $turma->certificado_liberado = 1;
            $turma->data_liberacao_certificado = now()->format('Y-m-d');

        $turma->save();

        return redirect()->back()->with('success', 'Turma fechada e certificados liberados com sucesso!');
    }
}
