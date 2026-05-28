<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PessoaController;
use App\Http\Controllers\Auth\UsuarioController;
use App\Http\Controllers\Auth\EventoController;
use App\Http\Controllers\Auth\DisciplinaController;
use App\Http\Controllers\Auth\TurmaController;
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


Route::put('/usuarios/{id_usuario}', [UsuarioController::class, 'update'])
    ->name('usuarios.update');


Route::get('/usuarios/cadastrar', [UsuarioController::class, 'create'])
    ->middleware('auth')
    ->name('usuarios.create');


Route::post('/usuarios/salvar', [UsuarioController::class, 'store'])
    ->name('usuarios.store');


Route::get('/usuario/{id}/historico', [UsuarioController::class, 'show'])
    ->middleware('auth')
    ->name('usuarios.historico');


Route::delete('/usuarios/{id_usuario}', [UsuarioController::class, 'destroy'])
    ->name('usuarios.destroy');


// --- ROTAS DE PESSOA ---
Route::get('/listaPessoa', [PessoaController::class, 'index'])
    ->middleware('auth')
    ->name('pessoas.index');


Route::get('/cadastrar-pessoa', [PessoaController::class, 'create'])
    ->middleware('auth')
    ->name('pessoas.create');


Route::put('pessoas/{id_pessoa}', [PessoaController::class, 'update'])
    ->name('pessoas.update');


Route::delete('pessoas/{id_pessoa}', [PessoaController::class, 'destroy'])
    ->name('pessoas.destroy');


Route::post('/pessoas/salvar', [PessoaController::class, 'store'])
    ->name('pessoas.store');


Route::get('/pessoa/{id}/historico', [PessoaController::class, 'show'])
    ->middleware('auth')
    ->name('pessoas.historico');


// --- ROTAS DE EVENTOS ---
Route::get('/eventos', [EventoController::class, 'index'])
    ->middleware('auth')
    ->name('eventos.index');

Route::put('/eventos/{id}', [EventoController::class, 'update'])
    ->name('eventos.update');

Route::get('/eventos/{id}', [EventoController::class, 'show'])
    ->middleware('auth')
    ->name('eventos.show');

Route::post('/eventos', [EventoController::class, 'store'])
    ->name('eventos.store');

Route::delete('/eventos/{id}', [EventoController::class, 'destroy'])
    ->name('eventos.destroy');

Route::get('/detalhesEventos', [EventoController::class, 'index'])
    ->middleware('auth')
    ->name('disciplinas.index');

Route::post('/eventos/{id}/disciplinas', [DisciplinaController::class, 'store'])
    ->name('disciplinas.store');

Route::put('/disciplinas/{id_disciplina}', [DisciplinaController::class, 'update'])
    ->name('disciplinas.update');

Route::delete('/disciplinas/{id}', [DisciplinaController::class, 'destroy'])
    ->name('disciplinas.destroy');


// --- ROTAS DE TURMAS ---
Route::get('/turmas', [TurmaController::class, 'index'])
    ->middleware('auth')
    ->name('turmas.index');

Route::post('/turmas', [TurmaController::class, 'store'])
    ->name('turmas.store');

Route::put('/turmas/{id}', [TurmaController::class, 'update'])
    ->name('turmas.update');

Route::get('/turmas/{id}/participantes', [TurmaController::class, 'participantes'])
->name('turmas.participantes');

Route::get('/turmas/{id}', [TurmaController::class, 'show'])
    ->middleware('auth')
    ->name('turmas.show');

Route::post('/turmas/{id}/vincular-instrutor', [TurmaController::class, 'vincularInstrutor'])
    ->name('turmas.vincularInstrutor');

Route::post('/turmas/{id}/vincular-aluno', [TurmaController::class, 'vincularAluno'])
    ->name('turmas.vincularAluno');

Route::post('/turmas/{id}/fechar', [TurmaController::class, 'fecharTurma'])
    ->name('turmas.fechar');

Route::delete('/turmas/{id_turma}/removerInstrutor/{id_pessoa}', [TurmaController::class, 'removerInstrutor'])
    ->name('turmas.removerInstrutor');

Route::delete('/turmas/{id_turma}/removerAluno/{id_pessoa}', [TurmaController::class, 'removerAluno'])
    ->name('turmas.removerAluno');

Route::delete('/turmas/{id}', [\App\Http\Controllers\Auth\TurmaController::class, 'destroy'])
    ->middleware('auth')
    ->name('turmas.destroy');

// --- AUTENTICAÇÃO ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');