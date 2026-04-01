<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PessoaController;
use App\Http\Controllers\Auth\UsuarioController;
use Illuminate\Support\Facades\Route;

// Redirecionamento Inicial
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('auth.dashboard');
})->middleware('auth')->name('dashboard');

// --- ROTAS DE USUÁRIO ---
// Lista de Usuários
Route::get('/usuarios', [UsuarioController::class, 'index'])
    ->middleware('auth')
    ->name('usuarios.index');

// Formulário de Cadastro de Usuário (AQUI ESTAVA O ERRO DO ESPAÇO)
Route::get('/usuarios/cadastrar', [UsuarioController::class, 'create'])
    ->middleware('auth')
    ->name('usuarios.create');


// --- ROTAS DE PESSOA ---
Route::get('/listaPessoa', [PessoaController::class, 'index'])
    ->middleware('auth')
    ->name('pessoas.index');

Route::get('/cadastrar-pessoa', [PessoaController::class, 'create'])
    ->middleware('auth')
    ->name('pessoas.create');

Route::delete('pessoas/{id_pessoa}', [PessoaController::class, 'destroy'])
    ->name('pessoas.destroy');


// --- AUTENTICAÇÃO ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');