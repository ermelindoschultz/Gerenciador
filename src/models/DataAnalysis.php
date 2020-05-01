<?php

require_once 'Database.php';

class DataAnalysis{
    public $colorize;

    function __construct(){
        $this->colorize = [ "rgba(0, 99, 132, 0.5)", "rgba(255, 99, 132, 0.5)", "rgb(85, 255, 0, 0.5)", "rgb(255, 255, 102)", "rgb(255, 153, 255)"];
    }

    function faturamentoTotal(){
        $db = new Database();

        $query = "SELECT SUM(valor) as 'faturamento_total' FROM vendas;";

        $result = $db->complex_query($query);

        if(!$result){
            return false;
        }

        $row = $result->fetch_assoc();
        
        return $row['faturamento_total'];
    }

    function faturamentoMensalPorAno($ano){
        $db = new Database();

        $query = "SELECT SUM(valor) as 'faturamento', MONTH(data_venda) as 'mes' FROM vendas WHERE YEAR(data_venda) = ".$ano." GROUP BY MONTH(data_venda)";

        $result = $db->complex_query($query);

        if(!$result){
            return false;
        }

        $dataset["label"] = $ano;

        $data = [];
        while($row = $result->fetch_assoc()){
            $data[$row["mes"]] = $row["faturamento"];
        }

        $dataset["data"] = $data;

        
        return $dataset;

    }

    function vendasPorProduto($id_produto,$ano){
        $db = new Database();

        $query = "SELECT COUNT(id) as total, MONTh(data_venda) as mes FROM vendas WHERE YEAR(data_venda) = ".$ano." AND id_produto = ".$id_produto." GROUP BY MONTH(data_venda);";

        $result = $db->complex_query($query);

        if(!$result){
            return false;
        }

        $dataset["label"] = $ano;

        $data = [];
        while($row = $result->fetch_assoc()){
            $data[$row["mes"]] = $row["total"];
        }

        $dataset["data"] = $data;

        
        return $dataset;

    }

    function faturamentoPorProduto($id_produto,$ano){
        $db = new Database();
        
        $query = "SELECT SUM(valor) as faturamento, MONTH(data_venda) as mes FROM vendas WHERE YEAR(data_venda) = ".$ano." AND id_produto = ".$id_produto." GROUP BY MONTH(data_venda);";

        $result = $db->complex_query($query);

        if(!$result){
            return false;
        }

        $dataset["label"] = $ano;

        $data = [];
        while($row = $result->fetch_assoc()){
            $data[$row["mes"]] = $row["faturamento"];
        }

        $dataset["data"] = $data;

        
        return $dataset;
    }

    function vendasPorVendedor($id_vendedor,$ano){
        $db = new Database();

        $query = "SELECT COUNT(id) as total, MONTh(data_venda) as mes FROM vendas WHERE YEAR(data_venda) = ".$ano." AND id_vendedor = ".$id_vendedor." GROUP BY MONTH(data_venda);";

        $result = $db->complex_query($query);

        if(!$result){
            return false;
        }

        $dataset["label"] = $ano;

        $data = [];
        while($row = $result->fetch_assoc()){
            $data[$row["mes"]] = $row["total"];
        }

        $dataset["data"] = $data;

        
        return $dataset;

    }

    function faturamentoPorVendedor($id_vendedor,$ano){
        $db = new Database();
        
        $query = "SELECT SUM(valor) as faturamento, MONTH(data_venda) as mes FROM vendas WHERE YEAR(data_venda) = ".$ano." AND id_vendedor = ".$id_vendedor." GROUP BY MONTH(data_venda);";

        $result = $db->complex_query($query);

        if(!$result){
            return false;
        }

        $dataset["label"] = $ano;

        $data = [];
        while($row = $result->fetch_assoc()){
            $data[$row["mes"]] = $row["faturamento"];
        }

        $dataset["data"] = $data;

        
        return $dataset;
    }

    function prepareForVisualAnalysis($type, $datasets){
        $prepared_datasets = [];

        $max = 0;
        foreach($datasets as $dataset){
            $maxdataset = max(array_values($dataset["data"]));

            if($maxdataset > $max){
                $max = $maxdataset;
            }

            $prepared_datasets[] = [
                "label" => $dataset["label"],
                "data" => array_values($dataset["data"]),
                "backgroundColor" => $dataset["color"],
                "borderColor" => $dataset["color"],
                "borderWidth" => 1

            ];
        }

        $chartConfig = [
            "max_value" => $max,
            "type" => $type,
            "datasets" => $prepared_datasets
        ];
        return $chartConfig;
    }
}