<?php
    require_once 'src/models/Produto.php';

    if(isset($_POST["editar"]) && isset($_POST["nome"]) && isset($_POST["valor"]) && isset($_POST["id"])){
        $produto = new Produto($_POST["nome"],$_POST["valor"]);
        $produto->setId($_POST["id"]);
        $feedback = $produto->update();

        if($feedback){
            $msg = "Informações do produto editadas sucesso!";
        }else{
            $msg = "Houve um erro ao tentar editar as informações do produto. Por favor, tente novamente, Se o erro persistir, contate o desenvolvedor.";
        }
    }

    $produto = new Produto();
    $produto->setId($_GET["id"]);
    if( !$produto->getFromDB() ){
        header('Location: produtos.php');
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.maskMoney.js"></script>
        <script src="js/validation.js"></script>
        <meta charset="utf-8" />
        <title>Gerenciador de Produtos</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-sm bg-light navbar-light">
            <a class="navbar-brand" href="index.php">Gerenciador de Produtos</a>
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="produtos.php">Produtos</a>
                </li> 
                <li class="nav-item">
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
                    <h1>Adicionar informações de produto</h1>
                </div>
            </div>
        </div>
        <div class="container">
            <?php if(!empty($msg)){ ?>
                <div class="row alert <?=($feedback)? "alert-success" :"alert-danger"; ?> ">
                    <?=$msg;?>
                </div>
            <?php } ?>
            <form action="editar_produto.php?id=<?=$produto->getId()?>" method="post">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?=$produto->getNome()?>">
                </div>
                <div class="form-group">
                    <label for="sobrenome">Valor</label>
                    <input type="number" step="any" class="form-control money" id="valor" name="valor" value="<?=money_format("%n",$produto->getValor())?>">
                </div>
                <input type="hidden" name="editar">
                <input type="hidden" name="id" value="<?=$produto->getId()?>">
                <button type="submit" class="btn btn-primary">Editar</button>
                <button type="button" class="btn btn-danger" onclick="location.href = 'produtos.php'">Cancelar</button>
            </form>
        </div>
    </body>
</html>