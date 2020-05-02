<?php

require_once 'CRUD.php';

class Venda extends CRUD{
    protected $id; 
    protected $id_vendedor;
    protected $vendedor_nome;
    protected $vendedor_sobrenome;
    protected $id_produto;
    protected $produto_nome;
    protected $valor;
    protected $observacao;
    protected $data_venda;

    const DB_TABLE_NAME = "vendas";

    function __construct($id_vendedor = '',$id_produto = '',$valor = '',$observacao = '',$data_venda = ''){
        $this->id_vendedor = $id_vendedor;
        $this->id_produto = $id_produto;
        $this->valor = $valor;
        $this->observacao = $observacao;
        $this->data_venda = $data_venda;
        $this->tableName = Venda::DB_TABLE_NAME;
    }

    function older(){
        $db = new Database();

        $result = $db->read_query($this->tableName, [], ["data_venda"], 1, 1, 0);

        if(!$result){
            return false;
        }
        $row = $result->fetch_assoc();

        if(empty($row)){
            return false;
        }

        return $row;
    }
    
    function younger(){
        $db = new Database();

        $result = $db->read_query($this->tableName, [], ["data_venda"], -1, 1, 0);

        if(!$result){
            return false;
        }
        $row = $result->fetch_assoc();

        if(empty($row)){
            return false;
        }

        return $row;
        

    }

    function setDataValues(){
        $this->dataValues = [
            "id" => $this->id,
            "id_vendedor" => $this->id_vendedor,
            "id_produto" => $this->id_produto,
            "valor" => $this->valor,
            "observacao" => $this->observacao,
            "data_venda" => $this->data_venda
        ];
    }

    function setId($id){
        $this->id = $id;
    }

    function getId(){
        return $this->id;
    }

    function setIdVendedor($id_vendedor){
        $this->id_vendedor = $id_vendedor;
    }

    function getIdVendedor(){
        return $this->id_vendedor;
    }

    function setIdProduto($id_produto){
        $this->id_produto = $id_produto;
    }

    function getIdProduto(){
        return $this->id_produto;
    }

    function setValor($valor){
        $this->valor = $valor;
    }

    function getValor(){
        return $this->valor;
    }

    function setObservacao($observacao){
        $this->observacao = $observacao;
    }

    function getObservacao(){
        return $this->observacao;
    }

    function setDataVenda($data_venda){
        $this->data_venda = $data_venda;
    }

    function getDataVenda(){
        return $this->data_venda;
    }

    function setNomeVendedor($nome_vendedor){
        $this->nome_vendedor = $nome_vendedor;
    }

    function getNomeVendedor(){
        return $this->nome_vendedor;
    }

    function setSobrenomeVendedor($sobrenome_vendedor){
        $this->sobrenome_vendedor = $sobrenome_vendedor;
    }

    function getSobrenomeVendedor(){
        return $this->sobrenome_vendedor;
    }
}

?>