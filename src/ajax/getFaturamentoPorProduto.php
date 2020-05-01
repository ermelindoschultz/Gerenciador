<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(__DIR__."/../models/DataAnalysis.php");
require_once(__DIR__."/../models/Produto.php");


if(isset($_GET["ano"]) && isset($_GET["id_produto"])){
    $analyst = new DataAnalysis();
    $produto = new Produto();

    
    $numMeses = 12;

    $datasetA = $analyst->faturamentoPorProduto($_GET["id_produto"], $_GET["ano"]);
    
    $produto->getFromDB($_GET["id_produto"]);

    $datasetA["label"] = $produto->getNome();

    $datasets[] = $datasetA;

    
    if( is_numeric($_GET['id_produto_comparar']) ){

        $datasetB = $analyst->faturamentoPorProduto($_GET["id_produto_comparar"], $_GET["ano"]);
        
        $produto->getFromDB($_GET["id_produto_comparar"]);

        $datasetB["label"] = $produto->getNome();

        $datasets[] = $datasetB;
    }

    for($i=0; $i < sizeof($datasets); $i++){
        $datasets[$i]["color"] = $analyst->colorize[$i];
        $labels = array_keys($datasets[$i]["data"]);
        for($m = 1; $m <= $numMeses; $m++){
            if( !in_array($m, $labels)){
                $datasets[$i]["data"][$m] = 0;
            }
        }

        ksort($datasets[$i]["data"]);
    }

    $chartConfig = $analyst->prepareForVisualAnalysis("line", $datasets);

    echo json_encode($chartConfig);
}

?>