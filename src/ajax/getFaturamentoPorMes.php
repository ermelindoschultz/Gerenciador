<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(__DIR__."/../models/DataAnalysis.php");


if(isset($_GET["ano"])){
    $analyst = new DataAnalysis();

    $numMeses = 12;

    $datasetA = $analyst->faturamentoMensalPorAno($_GET["ano"]);

    $datasets[] = $datasetA;
   
    
    if( is_numeric($_GET['ano_comparar']) ){
        $datasetB = $analyst->faturamentoMensalPorAno($_GET["ano_comparar"]);

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