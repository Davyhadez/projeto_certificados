<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Lotacao;
use App\Models\Pessoa;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{



    public function index(Request $request)
    {
        $lotacoes = Lotacao::orderBy('nome_lotacao', 'asc')->get();
        $busca = $request->input('pesquisarUser');
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
        $usuario = Usuario::findOrFail($id);

        $pessoa = Pessoa::with('lotacao')->findOrFail($usuario->id_pessoa);

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
            'senha_usuario'   => bcrypt($request->senha_usuario),
            'id_tipo_usuario' => $request->id_tipo_usuario,
            'ativo'           => $request->ativo
        ]);
        return redirect()->route('usuarios.index')->with('success', 'Usuário vinculado com sucesso!');
    }


    public function update(Request $request, $id_usuario)
    {
        $request->validate([
            'login_usuario'    => 'required|string|max:255',
            'senha_usuario'    => 'nullable|min:4',
            'id_tipo_usuario'  => 'required',
            'ativo'            => 'required'
        ]);


        $usuario = Usuario::findOrFail($id_usuario);

        $dados = $request->except(['senha_usuario']);

        if ($request->filled('senha_usuario')) {
            $dados['senha_usuario'] = bcrypt($request->input('senha_usuario'));
        }

        $usuario->update($dados);
        
        return redirect()->route('usuarios.index')->with('success', 'Edição atualizada com sucesso!');
    }


    public function destroy(Request $request, $id_usuario)
    {
        $request->validate([
            'password_confirm' => 'required'
        ]);

        $senha_valida = false;
        if (strlen(Auth::user()->senha_usuario) === 32) {
            $senha_valida = (md5($request->password_confirm) === Auth::user()->senha_usuario);
        } else {
            $senha_valida = Hash::check($request->password_confirm, Auth::user()->senha_usuario);
        }

        if (!$senha_valida) {
            return redirect()->route('usuarios.index')->with('error', 'Senha incorreta!');
        }


        try {
            $usuario = Usuario::findOrFail($id_usuario);
            
            try {
                // Tenta deletar fisicamente do banco
                $usuario->delete();
                $mensagem = 'Registro removido com sucesso!';
            } catch (\Illuminate\Database\QueryException $e) {
                // Se houver trava de chave estrangeira (código 23000), fazemos o Soft Delete (inativação)
                if ($e->getCode() == 23000) {
                    $usuario->ativo = 0;
                    $usuario->save();
                    $mensagem = 'O usuário não pode ser excluído por ter vínculos ativos (ex: Turmas). Ele foi INATIVADO com sucesso!';
                } else {
                    throw $e;
                }
            }

            return redirect()->route('usuarios.index')->with('success', $mensagem);
        } catch (\Exception $e) {
            return back()->with('error', 'Não foi possível excluir: ' . $e->getMessage());
        }
    }
}
