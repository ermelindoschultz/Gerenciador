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
    function getByPrimaryKey($table, $id){
        $query = "SELECT * FROM ".$table." WHERE id = ".$id;
        return $this->connection->query($query);
    }

    /*
    $foreing_data = [
        [
            "model" => "name of model related to table",
            "fk" => "foreign key",
            "pk" => "primary key on foreign table",
            "table" => "foreign table",
            "columns" => ["column1", "column2", ...]
        ]
    ],
    */
    function getByPrimaryKeyWithForeignData($table,$id,$foreing_data){
        if(empty($foreing_data)){
            $query = "SELECT * FROM ".$table." WHERE id = ".$id;
        }else{
            $foreing_columns = "";
            $foreing_expressions = "";
            $foreing_tables = "";
            $inner_joins = "";
            foreach($foreing_data as $foreing){
                foreach($foreing["columns"] as $column){
                    $foreing_columns .= ",".$foreing["table"].".".$column." as ".$foreing["model"]."_".$column;
                }
                $inner_joins .= " INNER JOIN ".$foreing["table"]." ON ".$table.".".$foreing["fk"]." = ".$foreing["table"].".".$foreing["pk"];
            }

            $foreing_columns = substr($foreing_columns,1);
            $foreing_tables = substr($foreing_tables,1);
            $foreing_expressions = substr($foreing_expressions,5);

            $query = "SELECT ".$table.".*,".$foreing_columns." FROM ".$table.$inner_joins." WHERE ".$table.".id = ".$id;
        }

        return $this->connection->query($query);
    }
    function read_query_withforeingdata($table, $columns = [], $orderby = [], $order_sort = 1, $limit = -1 , $offset = 0, $foreing_data = []){
        $columns_string = "";

        if(!empty($foreing_data)){
            $foreing_columns = "";
            $foreing_expressions = "";
            $foreing_tables = "";
            $inner_joins = "";
            foreach($foreing_data as $foreing){
                foreach($foreing["columns"] as $column){
                    $foreing_columns .= ",".$foreing["table"].".".$column." as ".$foreing["model"]."_".$column;
                }
                $inner_joins .= " INNER JOIN ".$foreing["table"]." ON ".$table.".".$foreing["fk"]." = ".$foreing["table"].".".$foreing["pk"];
            }
            $foreing_tables = substr($foreing_tables,1);
            $foreing_expressions = substr($foreing_expressions,5);
        }else{
            $foreing_columns = "";
            $foreing_expressions = "";
            $foreing_tables = "";
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

        $query = "SELECT ".$columns_string.$foreing_columns." FROM ".$table.$inner_joins;

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