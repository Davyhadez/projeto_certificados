<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Lotacao;
use App\Models\Pessoa;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{



    public function index(Request $request)
    {
        $busca = $request->input('pesquisarUser');
        $lotacoes = Lotacao::orderBy('nome_lotacao', 'asc')->get();

        $usuarios = Usuario::with('lotacao')
            ->when($busca, function ($query, $busca) {
                return $query->where('login_usuario', 'like', "%{$busca}%");
            })
            ->paginate(10);

        return view('auth.listaUsuario', compact('usuarios', 'lotacoes'));
    }



    public function create()
    {
        $pessoas = Pessoa::orderBy('nome_pessoa', 'asc')->get();

        return view('auth.cadUsuario', compact('pessoas'));
    }



    public function show($id)
    {
        // Busca o usuário ou retorna erro 404 se não existir
        $usuario = Usuario::findOrFail($id);

        // Busca a pessoa associada ao usuário, carregando a lotação
        $pessoa = Pessoa::with('lotacao')->findOrFail($usuario->id_pessoa);

        // Retorna a sua nova view enviando os dados do usuário
        return view('auth.historicoUsuario', [
            'u' => $usuario,
            'pessoa' => $pessoa
        ]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'id_pessoa'       => 'required|exists:pessoa,id_pessoa',
            'login_usuario'   => 'required|unique:usuario,login_usuario',
            'senha_usuario'   => 'required|min:4',
            'id_tipo_usuario' => 'required',
            'ativo'           => 'required'
        ]);


        Usuario::create([
            'id_pessoa'       => $request->id_pessoa,
            'login_usuario'   => $request->login_usuario,
            'senha_usuario'   => md5($request->senha_usuario),
            'id_tipo_usuario' => $request->id_tipo_usuario,
            'ativo'           => $request->ativo
        ]);
        return redirect()->route('usuarios.index')->with('success', 'Usuário vinculado com sucesso!');
    }


    public function update(Request $request, $id_usuario)
    {
        $request->validate([
            'login_usuario'     => 'required|string|max:255',
            'senha_usuario'    => 'nullable|min:4',
            'id_tipo_usuario'  => 'required',
            'ativo'            => 'required'
        ]);


        $usuario = Usuario::findOrFail($id_usuario);

        $dados = $request->except(['senha_usuario']);

        if ($request->filled('senha_usuario')) {
            $dados['senha_usuario'] = md5($request->input('senha_usuario'));
        }

        $usuario->update($dados);
        
        return redirect()->route('usuarios.index')->with('success', 'Edição atualizada com sucesso!');
    }


    public function distroy($id_usuario)
    {
        $usuario = Usuario::findOrFail($id_usuario);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuário excluído com sucesso!');
    }
}
