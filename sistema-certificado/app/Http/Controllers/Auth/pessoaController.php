<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Lotacao;
use App\Models\Pessoa;
use Illuminate\Http\Request;

class PessoaController extends Controller
{
    public function create()
    {
        $lotacoes = Lotacao::all();
        return view('auth.cadPessoa', compact('lotacoes'));
    }

    public function index(Request $request)
    {
        $busca = $request->input('pesquisarUser');
        $pessoas = Pessoa::with('lotacao')
        ->when($busca, function ($query, $busca) {
            return $query->where('nome_pessoa', 'like', "%{$busca}%");
        })
        ->orderBy('nome_pessoa')
        ->get(); // Ou ->paginate(10); se preferir

    return view('auth.listaPessoa', compact('pessoas'));
    }
}
