<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(__DIR__."/../models/DataAnalysis.php");
require_once(__DIR__."/../models/Vendedor.php");


if(isset($_GET["ano"]) && isset($_GET["id_vendedor"])){
    $analyst = new DataAnalysis();
    $vendedor = new Vendedor();

    
    $numMeses = 12;

    $datasetA = $analyst->faturamentoPorVendedor($_GET["id_vendedor"], $_GET["ano"]);
    
    $vendedor->setId($_GET["id_vendedor"]);
    $vendedor->getFromDB();

    $datasetA["label"] = $vendedor->getNome(). " ".$vendedor->getSobrenome();

    $datasets[] = $datasetA;

    
    if( is_numeric($_GET['id_vendedor_comparar']) ){

        $datasetB = $analyst->faturamentoPorVendedor($_GET["id_vendedor_comparar"], $_GET["ano"]);
        
        $vendedor->setId($_GET["id_vendedor_comparar"]);
        $vendedor->getFromDB();

        $datasetB["label"] = $vendedor->getNome(). " ".$vendedor->getSobrenome();

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