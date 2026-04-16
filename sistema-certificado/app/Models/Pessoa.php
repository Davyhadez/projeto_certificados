<?php

    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;

    class Pessoa extends Model {

        public $timestamps = false;
        protected $table = 'pessoa';
        protected $primaryKey = 'id_pessoa';
        protected $fillable = ['nome_pessoa','cpf',
                               'matricula', 'id_lotacao',
                               'data_nascimento', 'sexo',
                               'id_tipo_pessoa', 'ativo'];
        


        public function lotacao() {
        return $this -> belongsTo(Lotacao::class, 'id_lotacao', 'id_lotacao');
    }
    }
    //['nome_pessoa', 'cpf', 'matricula', 'lotacao', 'data_nascimento']