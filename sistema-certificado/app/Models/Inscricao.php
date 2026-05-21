<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    protected $table = 'inscricao';
    protected $primaryKey = 'id_inscricao';
    public $timestamps = false;

    protected $fillable = [
        'data_inscricao', 'id_pessoa', 'id_turma', 
        'conceito', 'frequencia', 'codigo_certificado'
    ];
}