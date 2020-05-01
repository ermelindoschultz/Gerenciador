<?php
    ini_set('display_errors', 1); 
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    require_once 'src/models/Venda.php';
    require_once 'src/models/Vendedor.php';
    require_once 'src/models/Produto.php';
    
    $produtos = Produto::list();
    $vendedores = Vendedor::list();

    if(isset($_POST["editar"]) && isset($_POST["id_vendedor"]) && isset($_POST["id_produto"]) && isset($_POST["valor"]) && 
       isset($_POST["dia_venda"]) && isset($_POST["hora_venda"]) && isset($_POST["id"])){

        $venda = new Venda();
        $venda->setId($_POST["id"]);
        $venda->setIdVendedor($_POST["id_vendedor"]);
        $venda->setIdProduto($_POST["id_produto"]);
        $venda->setValor($_POST["valor"]);
        $venda->setObservacao($_POST["observacao"]);
        $venda->setDataVenda(date("Y-m-d H:i:s", strtotime($_POST["hora_venda"]." ".$_POST["dia_venda"])));

        $feedback = $venda->update();

        if($feedback){
            $msg = "Informações da venda editadas sucesso!";
        }else{
            $msg = "Houve um erro ao tentar editar as informações da venda. Por favor, tente novamente, Se o erro persistir, contate o desenvolvedor.";
        }
    }

    $venda = new Venda();

    if( !$venda->getFromDB($_GET["id"],null) ){
        header('Location: vendas.php');
    };
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
                <li class="nav-item">
                    <a class="nav-link" href="vendedores.php">Vendedores</a>
                </li>
                <li class="nav-item active">
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
                    <h1>Editar informações de venda</h1>
                </div>
            </div>
        </div>
        <div class="container">
        <form action="editar_venda.php?id=<?=$venda->getId()?>" method="post">
            <div class="form-group">
                <label for="id_produto">Produto</label>
                <select class="custom-select my-1 mr-sm-2" id="id_produto" name="id_produto" required>
                    <?php foreach($produtos as $produto){ ?>
                        <option value="<?=$produto["id"]?>" <?=($produto["id"] == $venda->getIdProduto())?"selected":null;?>><?=$produto["nome"]?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_vendedor">Vendedor</label>
                <select class="custom-select my-1 mr-sm-2" id="id_vendedor" name="id_vendedor">
                <?php foreach($vendedores as $vendedor){ ?>
                        <option value="<?=$vendedor["id"]?>" <?=($vendedor["id"] == $venda->getIdVendedor())?"selected":null;?>><?=$vendedor["nome"]." ".$vendedor["sobrenome"]?>s</option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="valor">Valor</label>
                <input type="number" class="form-control" id="valor" name="valor" value="<?=$venda->getValor()?>" required>
            </div>
            <div class="form-group">
                <label for="observacao">Observação</label>
                <textarea class="form-control" id="observacao" name="observacao" placeholder="Escreva aqui sua observação"><?=$venda->getObservacao() ?? null;?></textarea>
            </div>
            <div class="form-group">
                <label for="dia_venda">Dia da Venda</label>
                <input type="date" class="form-control" id="dia_venda" name="dia_venda" value="<?=date("Y-m-d",strtotime($venda->getDataVenda()))?>" required>
            </div>
            <div class="form-group">
                <label for="hora_venda">Hora da Venda</label>
                <input type="time" class="form-control" id="hora_venda" name="hora_venda" value="<?=date("H:i",strtotime($venda->getDataVenda()))?>" required>
            </div>
            <input type="hidden" name="editar">
            <input type="hidden" name="id" value="<?=$venda->getId();?>">
            <button type="submit" class="btn btn-primary">Editar</button>
            <button type="button" class="btn btn-danger" onclick="location.href = 'vendas.php'">Cancelar</button>
        </form>
        </div>
    </body>
</html>