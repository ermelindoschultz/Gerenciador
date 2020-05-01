<?php

require_once 'Database.php';

class Produto{
    private $id; 
    private $nome;
    private $valor;

    const TABLE_NAME = "produtos";

    function __construct($nome = '', $valor = ''){
        $this->setNome($nome);
        $this->setValor($valor);
    }
    
    function create(){
        
        $db = new Database();
        $valores = [
            "nome" => $this->nome,
            "valor" => $this->valor
        ];

        $result = $db->cud_query(Produto::TABLE_NAME, Database::OP_INSERT, $valores);   

        $db->desconnect();
        
        return $result;
    }

    function update(){
        $db = new Database();
        $valores = [
            "id" => $this->id,
            "nome" => $this->nome,
            "valor" => $this->valor
        ];

        $result = $db->cud_query(Produto::TABLE_NAME, Database::OP_UPDATE, $valores);   

        $db->desconnect();
        
        return $result;
    }

    function delete(){
        $db = new Database();
        
        $valores = [
            "id" => $this->id
        ];

        $result = $db->cud_query(Produto::TABLE_NAME, Database::OP_DELETE, $valores);   

        $db->desconnect();
        
        return $result;
    }    

    public static function list($columns = [], $orderby = [], $order_sort = -1 , $offset = 0, $limit = -1){
        $db = new Database();
        
        $result = $db->read_query(Produto::TABLE_NAME, $columns, $orderby, $order_sort, $offset,$limit);

        $data = [];
        while($row = $result->fetch_row()){
            if( empty($columns) ){
                $data[] = [
                    "id" => $row[0],
                    "nome" => $row[1],
                    "valor" => $row[2]
                ];
            }else{
                $i = 0;
                $element = [];
                foreach($columns as $column){
                    $element[$column] = $row[$i];
                    $i++;
                }
                $data[] = $element;
            }
            
        };

        $db->desconnect();
        
        return $data;
    }
    
    public static function search(){
        return false;
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