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
        $request->validate([
            'nome_evento' => 'required|string|max:255',
            'id_tipo_evento' => 'required|integer',
        ]);

        $evento = Evento::findOrFail($id);


        $evento->update([
            'nome_evento' => $request->nome_evento,
            'id_tipo_evento' => $request->id_tipo_evento,
        ]);

        return redirect()->route('eventos.index')->with('success', 'Evento atualizado com sucesso!');
    }




    public function show($id)
    {
        $evento = Evento::with('disciplinas')->withCount('disciplinas')->findOrFail($id);

        $cargaTotal = $evento->disciplinas->sum('carga_horaria');

        return view('AUTH.detalhes-evento', compact('evento', 'cargaTotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome_evento'     => 'required|string|max:255',
            'id_tipo_evento'  => 'required|exists:tipo_evento,id_tipo_evento',
            'carga_horaria'   => 'required|integer|min:1',
        ]);

        Evento::create([

            'nome_evento'     => $request->input('nome_evento'),
            'id_tipo_evento'  => $request->input('id_tipo_evento'),
            'carga_horaria'   => $request->input('carga_horaria'),
        ]);
        return redirect()->route('eventos.index')->with('success', "Evento cadastrado com sucesso!");
    }
}
