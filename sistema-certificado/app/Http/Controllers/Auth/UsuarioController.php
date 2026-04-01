<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Lotacao;
use App\Models\Pessoa;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller {
    
    public function index(Request $request)
    {
        $busca = $request->input('pesquisarUser');

        $usuarios = Usuario::with('lotacao')
        ->when($busca, function ($query, $busca) {
            return $query->where('login_usuario', 'like', "%{$busca}%");
        })
        ->paginate(10);

        return view('auth.listaUsuario', compact('usuarios'));

    }

    public function create()
    {
        $pessoas = Pessoa::orderBy('nome_pessoa', 'asc') -> get();
        
        return view('auth.cadUsuario', compact('pessoas'));
    }
}