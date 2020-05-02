<?php
## Define as váriaveis para configuração e uso de banco de dados MySQL.

require_once(__DIR__."/../../config/database/database_constants.php");

class Database{
    const OP_INSERT = 1;

    const OP_SELECT = 2;

    const OP_UPDATE = 3;

    const OP_DELETE = 4;

    private $connection;

    function __construct(){
        $this->connection = new mysqli(MYSQL_HOST,MYSQL_USER,MYSQL_PASSWD,MYSQL_DBNAME,MYSQL_PORT,MYSQL_SOCKET);
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
    function getByPrimaryKey($table, $id){
        $query = "SELECT * FROM ".$table." WHERE id = ".$id;
        return $this->connection->query($query);
    }

    /*
    $foreign_data = [
        [
            "model" => "name of model related to table",
            "fk" => "foreign key",
            "pk" => "primary key on foreign table",
            "table" => "foreign table",
            "columns" => ["column1", "column2", ...]
        ]
    ],
    */
    function getByPrimaryKeyWithForeignData($table,$id,$foreignData){
        if(empty($foreignData)){
            $query = "SELECT * FROM ".$table." WHERE id = ".$id;
        }else{
            $foreign_columns = "";
            $foreign_expressions = "";
            $foreign_tables = "";
            $inner_joins = "";
            foreach($foreignData as $foreign){
                foreach($foreign["columns"] as $column){
                    $foreign_columns .= ",".$foreign["table"].".".$column." as ".$foreign["model"]."_".$column;
                }
                $inner_joins .= " INNER JOIN ".$foreign["table"]." ON ".$table.".".$foreign["fk"]." = ".$foreign["table"].".".$foreign["pk"];
            }

            $foreign_columns = substr($foreign_columns,1);
            $foreign_tables = substr($foreign_tables,1);
            $foreign_expressions = substr($foreign_expressions,5);

            $query = "SELECT ".$table.".*,".$foreign_columns." FROM ".$table.$inner_joins." WHERE ".$table.".id = ".$id;
        }

        return $this->connection->query($query);
    }
    function read_query_withforeigndata($table, $columns = [], $orderby = [], $order_sort = 1, $limit = -1 , $offset = 0, $foreignData = []){
        $columns_string = "";

        if(!empty($foreignData)){
            $foreign_columns = "";
            $foreign_expressions = "";
            $foreign_tables = "";
            $inner_joins = "";
            foreach($foreignData as $foreign){
                foreach($foreign["columns"] as $column){
                    $foreign_columns .= ",".$foreign["table"].".".$column." as ".$foreign["model"]."_".$column;
                }
                $inner_joins .= " INNER JOIN ".$foreign["table"]." ON ".$table.".".$foreign["fk"]." = ".$foreign["table"].".".$foreign["pk"];
            }
            $foreign_tables = substr($foreign_tables,1);
            $foreign_expressions = substr($foreign_expressions,5);
        }else{
            $foreign_columns = "";
            $foreign_expressions = "";
            $foreign_tables = "";
            $inner_joins = "";
        }

        if( empty($columns) ){
            $columns_string = $table."."."*";
        }else{
            foreach($columns as $column){
                $columns_string .= ", ".$table.".".$column;
            }
            $columns_string = substr($columns_string,1);
        };

        $query = "SELECT ".$columns_string.$foreign_columns." FROM ".$table.$inner_joins;

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

        if($limit >= 1){
            $query .= " LIMIT ".$limit;
        };

        if($offset > 0){
            $query .= " OFFSET ".$offset;
        };

        $query .= ";";

        return $this->connection->query($query);
    }
    function read_query($table, $columns = [], $orderby = [], $order_sort = 1, $limit = -1 , $offset = 0){
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

        if($limit >= 1){
            $query .= " LIMIT ".$limit;
        };

        if($offset > 0){
            $query .= " OFFSET ".$offset;
        };

        $query .= ";";

        return $this->connection->query($query);
    }

    function total($table){
        $query = "SELECT COUNT(*) FROM ".$table;

        return $this->connection->query($query)->fetch_row()[0];
    }

    function search_query($query){
        return false;
    }

    function complex_query($query){
        return $this->connection->query($query);
    }

    function desconnect(){
        return $this->connection->close();
    }
}

?>  