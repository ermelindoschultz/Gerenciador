<?php

require_once 'Database.php';

class Vendedor{
    private $id; 
    private $nome;
    private $sobrenome;

    const TABLE_NAME = "vendedores";

    function __construct($nome = '', $sobrenome = ''){
        $this->setNome($nome);
        $this->setSobrenome($sobrenome);
    }
    
    function create(){
        
        $db = new Database();
        $valores = [
            "nome" => $this->nome,
            "sobrenome" => $this->sobrenome
        ];

        $result = $db->cud_query(Vendedor::TABLE_NAME, Database::OP_INSERT, $valores);   

        $db->desconnect();
        
        return $result;
    }

    function update(){
        $db = new Database();
        $valores = [
            "id" => $this->id,
            "nome" => $this->nome,
            "sobrenome" => $this->sobrenome
        ];

        $result = $db->cud_query(Vendedor::TABLE_NAME, Database::OP_UPDATE, $valores);   

        $db->desconnect();
        
        return $result;
    }

    function delete(){
        $db = new Database();
        
        $valores = [
            "id" => $this->id
        ];

        $result = $db->cud_query(Vendedor::TABLE_NAME, Database::OP_DELETE, $valores);   

        $db->desconnect();
        
        return $result;
    }    

    function getFromDB($id){
        $db = new Database();

        $result = $db->getByPrimaryKey(Vendedor::TABLE_NAME, $id);   

        if(!$result){
            return $result;
        }

        $row = $result->fetch_row();

        if(empty($row)){
            return false;
        }

        $db->desconnect();
        
        $this->id = $id;
        $this->nome = $row[1];
        $this->sobrenome = $row[2];

        return true;
    }

    public static function total(){
        $db = new Database();
        
        $result = $db->total(Vendedor::TABLE_NAME);

        $db->desconnect();

        return $result;
        
    }

    public static function list($columns = [], $orderby = [], $order_sort = -1, $limit = -1 , $offset = 0){
        $db = new Database();
        
        $result = $db->read_query(Vendedor::TABLE_NAME, $columns, $orderby, $order_sort, $offset,$limit);

        $data = [];
        while($row = $result->fetch_row()){
            if( empty($columns) ){
                $data[] = [
                    "id" => $row[0],
                    "nome" => $row[1],
                    "sobrenome" => $row[2]
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

    function setSobrenome($sobrenome){
        $this->sobrenome = $sobrenome;
    }

    function getSobrenome(){
        return $this->sobrenome;
    }

}

?>