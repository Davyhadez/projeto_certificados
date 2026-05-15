<?php

    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;

    class SituacaoTurma extends Model {

        public $timestamps = false;
        protected $table = 'situacao_turma';
        protected $primaryKey = 'id_situacao_turma';
        protected $fillable = [];
    }

