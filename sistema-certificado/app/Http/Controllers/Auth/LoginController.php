<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

        $usuario = DB::table('usuario')
            -> where('login_usuario', $request->login_usuario)
            -> first();

        $isValid = false;
        
        if ($usuario) {
            // Se a senha no banco tiver 32 caracteres (tamanho padrão de MD5)
            if (strlen($usuario->senha_usuario) === 32) {
                // Checa com md5 antigo
                if (md5($request->password) === $usuario->senha_usuario) {
                    $isValid = true;
                    // Atualiza a senha no banco para o novo padrão Bcrypt
                    DB::table('usuario')
                        ->where('id_usuario', $usuario->id_usuario)
                        ->update(['senha_usuario' => bcrypt($request->password)]);
                }
            } else {
                // Se já estiver em Bcrypt, faz a validação padrão do Laravel
                if (Hash::check($request->password, $usuario->senha_usuario)) {
                    $isValid = true;
                }
            }
        }

        if ($isValid) { 
            
            if ($usuario -> ativo != 1) {
                return back() -> withErrors([
                'login_usuario' => "Usuário ou senha inválidos.",
                ]);
            }

            Auth::loginUsingId($usuario -> id_usuario);

            $request -> session() -> regenerate();

            return redirect() -> intended('dashboard');
        }

        return back() -> withErrors([
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
