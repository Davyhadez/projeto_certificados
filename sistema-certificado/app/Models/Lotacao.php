<?php
// filepath: app/Models/Lotacao.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lotacao extends Model
{
    protected $table = 'lotacao'; // Nome da tabela no banco de dados
    protected $fillable = ['nome', 'descricao']; // Exemplo
}