<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\TipoEvento;
use PhpParser\Builder\Function;

class EventoController extends Controller
{
    public function index(Request $request)
    {
        $eventos = Evento::with(['tipo'])->withCount('disciplinas')->paginate(10);
        $tipos = TipoEvento::all();

        return view('auth.eventos', compact('eventos', 'tipos'));
    }



    public function update(Request $request, $id)
    {
        $rules = [
            'nome_evento' => 'required|string|max:255',
            'id_tipo_evento' => 'required|integer',
        ];

        
        if ($request->id_tipo_evento == 1) { 
            $rules['carga_horaria'] = 'nullable|numeric';
        } else { 
            $rules['carga_horaria'] = 'required|numeric|min:1';
        }

        $request->validate($rules);

        $evento = Evento::findOrFail($id);

        $evento->nome_evento = $request->nome_evento;
        $evento->id_tipo_evento = $request->id_tipo_evento;

        if ($request->id_tipo_evento == 1) { 
            $evento->carga_horaria = 0;
        } else { 
            $evento->carga_horaria = $request->carga_horaria;
        }

        $evento->save();

        return redirect()->route('eventos.index')->with('success', 'Evento atualizado com sucesso!');
    }


    public function destroy($id)
    {
        $evento = Evento::findOrFail($id);

        $evento->disciplinas()->delete();

        $evento->delete();

        return redirect()->back()->with('success', 'Evento removido com sucesso!');
    }


    public function show($id)
    {
        $evento = Evento::with('disciplinas')->withCount('disciplinas')->findOrFail($id);

        $cargaTotal = $evento->disciplinas->sum('carga_horaria');

        return view('AUTH.detalhes-evento', compact('evento', 'cargaTotal'));
    }

    public function store(Request $request)
    {
        $rules = [
            'nome_evento'     => 'required|string|max:255',
            'id_tipo_evento'  => 'required|exists:tipo_evento,id_tipo_evento',
        ];

       
        if ($request->id_tipo_evento == 1) { 
            $rules['carga_horaria'] = 'nullable|numeric';
        } else { 
            $rules['carga_horaria'] = 'required|numeric|min:1';
        }

        $request->validate($rules);

        // Prepara os dados para criação
        $dados = $request->only(['nome_evento', 'id_tipo_evento', 'carga_horaria']);
        if ($request->id_tipo_evento == 1) { // Se for 'Curso'
            $dados['carga_horaria'] = 0; // Força a carga horária para 0
        }

        Evento::create($dados);

        return redirect()->route('eventos.index')->with('success', "Evento cadastrado com sucesso!");
    }
}
