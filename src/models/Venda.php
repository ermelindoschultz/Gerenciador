<?php

require_once 'Database.php';

class Venda{
    private $id; 
    private $id_vendedor;
    private $vendedor_nome;
    private $vendedor_sobrenome;
    private $id_produto;
    private $produto_nome;
    private $valor;
    private $observacao;
    private $data_venda;

    const TABLE_NAME = "vendas";

    function __construct($id_vendedor = '',$id_produto = '',$valor = '',$observacao = '',$data_venda = ''){
        $this->setIdVendedor($id_vendedor);
        $this->setIdProduto($id_vendedor);
        $this->setValor($valor);
        $this->setObservacao($observacao);
        $this->setDataVenda($data_venda);
    }
    
    function create(){
        
        $db = new Database();
        $valores = [
            "id_vendedor" => $this->id_vendedor,
            "id_produto" => $this->id_produto,
            "valor" => $this->valor,
            "observacao" => $this->observacao,
            "data_venda" => $this->data_venda
        ];

        $result = $db->cud_query(Venda::TABLE_NAME, Database::OP_INSERT, $valores);   

        $db->desconnect();
        
        return $result;
    }

    function update(){
        $db = new Database();
        $valores = [
            "id" => $this->id,
            "id_vendedor" => $this->id_vendedor,
            "id_produto" => $this->id_produto,
            "valor" => $this->valor,
            "observacao" => $this->observacao,
            "data_venda" => $this->data_venda
        ];

        $result = $db->cud_query(Venda::TABLE_NAME, Database::OP_UPDATE, $valores);   

        $db->desconnect();
        
        return $result;
    }

    function delete(){
        $db = new Database();
        
        $valores = [
            "id" => $this->id
        ];

        $result = $db->cud_query(Venda::TABLE_NAME, Database::OP_DELETE, $valores);   

        $db->desconnect();
        
        return $result;
    }   
    
    function getFromDB($id,$foreing_data){
        $db = new Database();

        $result = $db->getByPrimaryKeyWithForeignData(Venda::TABLE_NAME, $id, $foreing_data);   

        if(!$result){
            return $result;
        }

        $row = $result->fetch_assoc();

        if(empty($row)){
            return false;
        }

        $db->desconnect();
        
        $this->id = $id;
        $this->id_vendedor = $row["id_vendedor"];
        $this->id_produto = $row["id_produto"];
        $this->valor = $row["valor"];
        $this->observacao = $row["observacao"];
        $this->data_venda = $row["data_venda"];
        $this->vendedor_nome = isset($row["vendedor_nome"]) ?? null;
        $this->vendedor_sobrenome = isset($row["vendedor_sobrenome"]) ?? null;
        $this->produto_nome = isset($row["produto_nome"]) ?? null;

        return true;
    }

    public static function total(){
        $db = new Database();
        
        $result = $db->total(Venda::TABLE_NAME);

        $db->desconnect();

        return $result;
        
    }
    
    public static function list($columns = [], $orderby = [], $order_sort = -1, $limit = -1 , $offset = 0,$foreing_data = []){
        $db = new Database();
        
        $result = $db->read_query_withforeingdata(Venda::TABLE_NAME, $columns, $orderby, $order_sort, $offset,$limit, $foreing_data);

        $data = [];
        while($row = $result->fetch_assoc()){
            if( empty($columns) ){
                $data[] = [
                    "id" => $row["id"],
                    "valor" => $row["valor"],
                    "observacao" => $row["observacao"],
                    "data_venda" => $row["data_venda"],
                    "vendedor_nome" => ( isset($row["vendedor_nome"]) ) ? $row["vendedor_nome"] : null,
                    "vendedor_sobrenome" => ( isset($row["vendedor_sobrenome"]) ) ? $row["vendedor_sobrenome"] : null,
                    "produto_nome" => ( isset($row["produto_nome"]) ) ? $row["produto_nome"] : null
                ];
            }else{
                $element = [];
                foreach($columns as $column){
                    $element[$column] = $row[$column];
                }
                $element["vendedor_nome"] = ( isset($row["vendedor_nome"]) ) ? $row["vendedor_nome"] : null;
                $element["vendedor_sobrenome"] = ( isset($row["vendedor_sobrenome"]) ) ? $row["vendedor_sobrenome"] : null;
                $element["produto_nome"] = ( isset($row["produto_nome"]) ) ? $row["produto_nome"] : null;   

                $data[] = $element;
            }
            
        };

        $db->desconnect();

        
        
        return $data;
    }

    public static function older(){
        $db = new Database();

        $result = $db->read_query(Venda::TABLE_NAME, [], ["data_venda"], 1, 1, 0);

        if(!$result){
            return false;
        }
        $row = $result->fetch_assoc();

        if(empty($row)){
            return false;
        }

        return $row;
    }
    
    public static function younger(){
        $db = new Database();

        $result = $db->read_query(Venda::TABLE_NAME, [], ["data_venda"], -1, 1, 0);

        if(!$result){
            return false;
        }
        $row = $result->fetch_assoc();

        if(empty($row)){
            return false;
        }

        return $row;
        

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