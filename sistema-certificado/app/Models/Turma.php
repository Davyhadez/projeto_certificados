<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    protected $table = 'turma';
    protected $primaryKey = 'id_turma';
    public $timestamps = false;

    protected $fillable = [
        'descricao', 'data_inicio', 'data_fim',
        'data_registro', 'local_oferta', 'quantidade_maxima',
        'ativo', 'certificado_liberado', 'data_liberacao_certificado',
        'id_evento', 'id_usuario', 'id_situacao_turma',
        'frequencia'
    ];


    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }

    public function instrutores()
    {
        return $this->belongsToMany(
            Pessoa::class,
            'instrutor',
            'id_turma',
            'id_pessoa',
            'id_turma',
            'id_pessoa'
        );
    }

    public function alunos()
    {
        return $this->belongsToMany(
            Pessoa::class,
            'inscricao',
            'id_turma',
            'id_pessoa',
            'id_turma',
            'id_pessoa'
        )->withPivot('conceito', 'frequencia');
    }
}
