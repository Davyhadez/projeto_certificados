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
        // AQUI, UMA TURMA IRÁ PERTENCER A UM EVENTO
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }
}
