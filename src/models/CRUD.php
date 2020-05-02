<?php

require_once 'Database.php';

class CRUD{
    protected $dataValues;
    protected $tableName;

    function create(){
        
        $db = new Database();

        $this->setDataValues();
        
        $result = $db->cud_query($this->tableName, Database::OP_INSERT, $this->dataValues);   

        $db->desconnect();
        
        return $result;
    }

    function update(){
        $db = new Database();

        $this->setDataValues();

        $result = $db->cud_query($this->tableName, Database::OP_UPDATE, $this->dataValues);   

        $db->desconnect();
        
        return $result;
    }

    function delete(){
        $db = new Database();
        
        $this->setDataValues();

        $result = $db->cud_query($this->tableName, Database::OP_DELETE, $this->dataValues);   

        $db->desconnect();
        
        return $result;
    }  

    function getFromDB(){
        $db = new Database();

        $result = $db->getByPrimaryKey($this->tableName, $this->id);   

        if(!$result){
            return $result;
        }

        $row = $result->fetch_assoc();

        if(empty($row)){
            return false;
        }

        $db->desconnect();
        
        foreach($row as $key => $value){
            $this->$key = $value;
        }

        return true;
    }

    function getFromDBWithForeingData($foreignData){
        $db = new Database();

        $result = $db->getByPrimaryKeyWithForeignData($this->tableName, $id, $foreignData);   

        if(!$result){
            return $result;
        }

        $row = $result->fetch_assoc();

        if(empty($row)){
            return false;
        }

        $db->desconnect();
        
        foreach($row as $key => $value){
            $this->$key = isset($value) ?? null;
        }

        return true;
    }

    function list($columns = [], $orderby = [], $order_sort = -1, $limit = -1 , $offset = 0){
        $db = new Database();
        
        $result = $db->read_query($this->tableName, $columns, $orderby, $order_sort, $offset,$limit);

        if(!$result){
            return false;
        }
        
        $data = [];

        while($row = $result->fetch_assoc()){
            if( empty($columns) ){
                $row_data = $row;
                $data[] = $row_data;
            }else{
                $i = 0;
                $element = [];
                foreach($columns as $column){
                    $element[$column] = $row[$column];
                    $i++;
                }
                $data[] = $element;
            }
            
        };

        $db->desconnect();
        
        return $data;
    }

    function listWithForeignData($columns = [], $orderby = [], $order_sort = -1, $limit = -1 , $offset = 0,$foreign_data = []){
        $db = new Database();
        
        $result = $db->read_query_withforeigndata($this->tableName, $columns, $orderby, $order_sort, $offset,$limit, $foreign_data);

        $data = [];
        while($row = $result->fetch_assoc()){
            if( empty($columns) ){
                $row_data = $row;
                $data[] = $row_data;
            }else{
                $element = [];
                foreach($columns as $column){
                    $element[$column] = $row[$column];
                }

                //Updating foreign elements
                foreach($foreign_data as $fd){
                    foreach($fd["columns"] as $columns){
                        $foreign_column_name = $fd["model"]."_".$column;
                        $element[$foreign_column_name] = $row[$$foreign_column_name];
                    }
                }

                $data[] = $element;
            }
            
        };

        $db->desconnect();

        return $data;
    }

    function total(){
        $db = new Database();
        
        $result = $db->total($this->tableName);

        $db->desconnect();

        return $result;
        
    }

    public static function search(){
        return false;
    }

    function setDataValues(){
        return false;
    }

    function getDataValues(){
        return $this->dataValues;
    }

}
?>