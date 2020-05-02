<?php

require_once 'CRUD.php';

class Produto extends CRUD{
    protected $id; 
    protected $nome;
    protected $valor;

    const DB_TABLE_NAME = "produtos";

    function __construct($nome = '', $valor = ''){
        $this->nome = $nome;
        $this->valor = $valor;
        $this->tableName = Produto::DB_TABLE_NAME;
    }
    
    function setDataValues(){
        $this->dataValues = [
            "id" => $this->id,
            "nome" => $this->nome,
            "valor" => $this->valor,
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

    function setValor($valor){
        $this->valor = $valor;
    }

    function getValor(){
        return $this->valor;
    }

}

?>