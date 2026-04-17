<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Historico;
use App\Models\Lotacao;
use App\Models\Pessoa;
use Illuminate\Http\Request;

class PessoaController extends Controller
{

    //ESSENCIAL PARA O FUNCIONAMENTO DO SELECT DE LOTAÇÕES.
    public function create()
    {
        $lotacoes = Lotacao::all();
        return view('auth.cadPessoa', compact('lotacoes'));
    }

    public function index(Request $request)
    {
        $lotacoes = Lotacao::orderBy('nome_lotacao', 'asc') -> get();
        $busca = $request->input('pesquisarUser');
        $pessoas = Pessoa::with('lotacao')
        ->when($busca, function ($query, $busca) {
            return $query->where('nome_pessoa', 'like', "%{$busca}%");
        })
        ->orderBy('nome_pessoa')
        ->paginate(20);

    return view('auth.listaPessoa', compact('pessoas', 'lotacoes'));
    }

    public function show($id)
{
    // Busca a pessoa ou retorna erro 404 se não existir
    $pessoa = Pessoa::with('lotacao')->findOrFail($id);

    // Retorna a sua nova view enviando os dados da pessoa
    return view('auth.historicoPessoa', compact('pessoa'));
}

    public function store(Request $request)
    {
        $request->validate([
            'cpf'             => 'required|unique:pessoa,cpf',
            'nome_pessoa'     => 'required|string|max:255',
            'matricula'       => 'required|unique:pessoa,matricula',
            'data_nascimento' => 'required|date',
            'sexo'            => 'required',
            'id_lotacao'      => 'required|exists:lotacao,id_lotacao',
            'id_tipo_pessoa'  => 'required|exists:tipo_pessoa,id_tipo_pessoa',
            'ativo'           => 'required'
        ]);

        Pessoa::create([
            'cpf'             => $request->input('cpf'),
            'nome_pessoa'     => $request->input('nome_pessoa'),
            'matricula'       => $request->input('matricula'),
            'data_nascimento' => $request->input('data_nascimento'),
            'sexo'            => $request->input('sexo'),
            'id_lotacao'      => $request->input('id_lotacao'),
            'id_tipo_pessoa'  => $request->input('id_tipo_pessoa'),
            'ativo'           => $request->input('ativo')   
        ]);
        return redirect()->route('pessoas.index')->with('success', "Pessoa cadastrada com sucesso!");
    }

    public function update(Request $request, $id_pessoa)
    {
        $request->validate([
            'cpf'             => 'required|unique:pessoa,cpf,' . $id_pessoa . ',id_pessoa',
            'nome_pessoa'     => 'required|string|max:255',
            'matricula'       => 'required|unique:pessoa,matricula,' . $id_pessoa . ',id_pessoa',
            'data_nascimento' => 'required|date',
            'sexo'            => 'required',
            'id_lotacao'      => 'required|exists:lotacao,id_lotacao',
            'id_tipo_pessoa'  => 'required|exists:tipo_pessoa,id_tipo_pessoa',
            'ativo'           => 'required'
        ]);


        $pessoa = Pessoa::findOrFail($id_pessoa);
        $pessoa->update($request->all());
        $resultado = $pessoa->update($request->all());

        return redirect()->route('pessoas.index')->with('success', 'Edição atualizada com sucesso!');
    }

    public function destroy($id_pessoa)
    {
        $pessoa = Pessoa::findOrFail($id_pessoa);
        $pessoa->delete();

        return redirect()->route('pessoas.index')->with('success', 'Pessoa excluída com sucesso!');
    }
}
