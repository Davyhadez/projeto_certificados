<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        $request->validate([
            'login_usuario' => 'required',
            'password' => 'required'
        ]);

        $user = DB::table('usuario')
            ->where('login_usuario', $request->login_usuario)
            ->first();

        if ($user && md5($request -> password) === $user -> senha_usuario) { #tranforma em formato MD5 para comparar com o banco de dados
            
            if ($user -> ativo != 1) {
                return back()->withErrors([
                'login_usuario' => "Usuário ou senha inválidos.",
                ]);
            }

            Auth::loginUsingId($user -> id_usuario);

            $request -> session() -> regenerate();

            return redirect() -> intended('dashboard');
        }

        return back()->withErrors([
            'login_usuario' => "Usuário ou senha inválidos.",
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
