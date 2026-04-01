<?php

    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;

    class Pessoa extends Model {
        protected $table = 'pessoa';
        protected $primaryKey = 'id_pessoa';
        protected $fillable = ['nome_pessoa', 'cpf', 'matricula', 'id_lotacao', 'data_nascimento'];

        public function lotacao() {
        return $this -> belongsTo(Lotacao::class, 'id_lotacao', 'id_lotacao');
    }
    }
    //['nome_pessoa', 'cpf', 'matricula', 'lotacao', 'data_nascimento']