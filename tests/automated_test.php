<?php

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require(__DIR__."/../src/models/Database.php");
require(__DIR__."/../src/models/Vendedor.php");
require(__DIR__."/../src/models/Produto.php");
require(__DIR__."/../src/models/Venda.php");

$vendedor = new Vendedor();
$produto = new Produto();
$venda = new Venda();

$numProdutos = 30;
$numVendedores = 10;
$numVendas = 10000;
$anoInicio = 2015;
$anoFim = 2020;

#Cria vendedores e produtos
echo "Gerando dados de vendedores\n";

for($i=1; $i <= $numVendedores; $i++){
    $vendedor->setNome("Vendedor");
    $vendedor->setSobrenome($i);
    $vendedor->create();
}

echo "Gerando dados de produtos\n";
for($i=1; $i <= $numProdutos; $i++){
    $produto->setNome("Produto ".$i);
    $produto->setValor( round(rand()/rand(),2) );
    $produto->create();
}

$vendedores = $vendedor->list();
$produtos = $produto->list();

echo "Gerando dados de vendas aleatóriamente\n";
for($i=1; $i <= $numVendas; $i++){
    $vendedorIndex = rand(0,sizeof($vendedores) - 1);
    $venda->setIdVendedor($vendedores[$vendedorIndex]["id"]);
    $produtoIndex = rand(0,sizeof($produtos) - 1);
    $venda->setIdProduto($produtos[$produtoIndex]["id"]);
    $venda->setValor($produtos[$produtoIndex]["valor"]);
    $venda->setObservacao("Obs ".rand());
    $ano = rand($anoInicio,$anoFim);
    $mes = rand(1,12);
    $dia = rand(1,29);
    $venda->setDataVenda($ano."-".$mes."-".$dia." 13:00:00");
    $venda->create();
}

echo "Dados de teste gerados com sucesso\n";

?>