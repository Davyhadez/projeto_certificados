<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssinaturaController extends Controller
{
    public function index()
    {
        return view('auth.assinatura');
    }


    public function store(Request $request)
    {
        return redirect()->route('assinaturas.index')->with('success', 'Assinatura criada com sucesso!');
    }


    public function update(Request $request, $id)
    {
        return redirect()->route('assinaturas.index')->with('success', 'Assinatura atualizada com sucesso!');
    }


    public function destroy($id)
    {
        return redirect()->route('assinaturas.index')->with('success', 'Assinatura excluída com sucesso!');
    }
}