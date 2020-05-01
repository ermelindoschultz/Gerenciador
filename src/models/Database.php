<?php
## Define as váriaveis para configuração e uso de banco de dados MySQL.

class Database{
    const MYSQL_HOST = 'localhost';

    const MYSQL_USER = 'dev';

    const MYSQL_PASSWD = 'devpass';

    const MYSQL_DBNAME = 'gerenciador';

    const MYSQL_PORT = null;

    const MYSQL_SOCKET = null;

    const OP_INSERT = 1;

    const OP_SELECT = 2;

    const OP_UPDATE = 3;

    const OP_DELETE = 4;

    private $connection;

    function __construct(){
        $this->connection = new mysqli(Database::MYSQL_HOST,Database::MYSQL_USER,Database::MYSQL_PASSWD,Database::MYSQL_DBNAME);
    }

    function cud_query($table, $operation, $values){
        switch($operation){
            case Database::OP_INSERT:
                $columns_string = "";
                $values_string = "";
                foreach($values as $column => $value){
                    if($column != "id"){
                        $columns_string .= ",".$column."";
                        $values_string .= ",'".$value."'";
                    }
                };

                $values_string = substr($values_string, 1);
                $columns_string = substr($columns_string, 1);
                $query = "INSERT INTO ".$table." ( ".$columns_string." ) VALUES ( ".$values_string.");";
                
                return $this->connection->query($query);
            case Database::OP_UPDATE:
                $values_string = "";
                foreach($values as $column => $value){
                    if(strcmp($column,"id") != 0 ){
                        $values_string .= ",".$column." = '".$value."'";
                    }
                };

                $values_string = substr($values_string, 1);
                $query = "UPDATE ".$table." SET ".$values_string." WHERE id = ".$values["id"].";";
                
                return $this->connection->query($query);
            case Database::OP_DELETE:
                $query = "DELETE FROM ".$table." WHERE id = ".$values["id"].";";

                return $this->connection->query($query);
            default:
                return false;
        }
    }

    function read_query($table, $columns = [], $orderby = [], $order_sort = 1 , $offset = 0, $limit = -1){
        $columns_string = "";

        if( empty($columns) ){
            $columns_string = "*";
        }else{
            foreach($columns as $column){
                $columns_string .= ", ".$column;
            }
            $columns_string = substr($columns_string,1);
        };

        $query = "SELECT ".$columns_string." FROM ".$table;

        if( !empty($orderby) ){
            $orderby_string = "";
            foreach($orderby as $column){
                $orderby_string .= ",".$column;
            };

            $orderby_string = substr($orderby_string, 1);
            $query .= " ORDER BY ".$orderby_string;
            if($order_sort == 1){
                $query .= " ASC";
            }else{
                $query .= " DESC";
            };
        };

        if($offset > 0){
            $query .= " OFFSET ".$offset;
        };

        if($limit >= 1){
            $query .= " LIMIT ".$limit;
        };

        $query .= ";";

        echo $query;

        return $this->connection->query($query);
    }
    function search_query($query){
        return false;
    }

    function desconnect(){
        return $this->connection->close();
    }
}

?>  