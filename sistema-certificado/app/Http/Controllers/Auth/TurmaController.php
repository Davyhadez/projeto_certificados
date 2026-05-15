<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\usuario;
use App\Models\Evento;
use App\Models\SituacaoTurma;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class TurmaController extends Controller
{
    public function index(Request $request)
    {
        // Lógica para listar as turmas
        return view('auth.turmas');
    }
}
