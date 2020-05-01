<?php
    ini_set('display_errors', 1); 
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    require_once 'src/models/Vendedor.php';

    if(isset($_POST["editar"]) && isset($_POST["nome"]) && isset($_POST["sobrenome"]) && isset($_POST["id"])){
        $vendedor = new Vendedor($_POST["nome"],$_POST["sobrenome"]);
        $vendedor->setId($_POST["id"]);
        $feedback = $vendedor->update();

        if($feedback){
            $msg = "Informações do vendedor editadas sucesso!";
        }else{
            $msg = "Houve um erro ao tentar editar as informações do vendedor. Por favor, tente novamente, Se o erro persistir, contate o desenvolvedor.";
        }
    }

    $vendedor = new Vendedor();
    
    if( !$vendedor->getFromDB($_GET["id"]) ){
        header('Location: vendedores.php');
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <meta charset="utf-8" />
        <title>Gerenciador de Produtos</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-sm bg-light navbar-light">
            <a class="navbar-brand" href="index.php">Gerenciador de Produtos</a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="produtos.php">Produtos</a>
                </li> 
                <li class="nav-item active">
                    <a class="nav-link" href="vendedores.php">Vendedores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="vendas.php">Vendas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="relatorios.php">Relatórios</a>
                </li>
            </ul>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-sm text-center">
                    <h1>Editar informações de vendedor</h1>
                </div>
            </div>
        </div>
        <div class="container">
        <form action="editar_vendedor.php?id=<?=$vendedor->getId()?>" method="post">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?=$vendedor->getNome();?>">
            </div>
            <div class="form-group">
                <label for="sobrenome">Sobrenome</label>
                <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="<?=$vendedor->getSobrenome();?>">
            </div>
            <input type="hidden" name="editar">
            <input type="hidden" name="id" value="<?=$vendedor->getId();?>">
            <button type="submit" class="btn btn-primary">Editar</button>
            <button type="button" class="btn btn-danger" onclick="location.href = 'vendedores.php'">Cancelar</button>
        </form>
        </div>
    </body>
</html>