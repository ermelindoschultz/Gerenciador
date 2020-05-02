<?php

require_once 'CRUD.php';

class Vendedor extends CRUD{
    protected $id; 
    protected $nome;
    protected $sobrenome;

    const DB_TABLE_NAME = "vendedores";

    function __construct($nome = '', $sobrenome = ''){
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->tableName = Vendedor::DB_TABLE_NAME;
    }

    function setDataValues(){
        $this->dataValues = [
            "id" => $this->id,
            "nome" => $this->nome,
            "sobrenome" => $this->sobrenome
        ];
    }

    function setId($id){
        $this->id = $id;
    }

    function getId(){
        return $this->id;
    }

    function setNome($nome){
        $this->nome = $nome;
    }

    function getNome(){
        return $this->nome;
    }

    function setSobrenome($sobrenome){
        $this->sobrenome = $sobrenome;
    }

    function getSobrenome(){
        return $this->sobrenome;
    }

}

?>