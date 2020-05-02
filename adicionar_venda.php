<?php

    require_once 'src/models/Vendedor.php';
    require_once 'src/models/Produto.php';
    
    $produto = new Produto();
    $vendedor = new Vendedor();

    $produtos = $produto->list();
    $vendedores = $vendedor->list();

    if(empty($produtos) || empty($vendedores)){
        header("Location: vendas.php?err=1");
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
                    <h1>Adicionar nova venda</h1>
                </div>
            </div>
        </div>
        <div class="container">
        <form action="vendas.php" method="post">
            <div class="form-group">
                <label for="id_produto">Produto</label>
                <select class="custom-select my-1 mr-sm-2" id="id_produto" name="id_produto" required>
                    <?php foreach($produtos as $produto){ ?>
                        <option value="<?=$produto["id"]?>"><?=$produto["nome"]?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_vendedor">Vendedor</label>
                <select class="custom-select my-1 mr-sm-2" id="id_vendedor" name="id_vendedor">
                <?php foreach($vendedores as $vendedor){ ?>
                        <option value="<?=$vendedor["id"]?>"><?=$vendedor["nome"]." ".$vendedor["sobrenome"]?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="valor">Valor</label>
                <input type="number" step=any class="form-control money" id="valor" name="valor" value="<?=money_format("%n",$produto["valor"])?>" required>
            </div>
            <div class="form-group">
                <label for="observacao">Observação</label>
                <textarea class="form-control" id="observacao" name="observacao" placeholder="Escreva aqui sua observação"></textarea>
            </div>
            <div class="form-group">
                <label for="dia_venda">Dia da venda</label>
                <input type="date" class="form-control" id="dia_venda" name="dia_venda" value="<?=date("Y-m-d")?>" required>                
            </div>
            <div class="form-group">
                <label for="hora_venda">Hora da Venda</label>
                <input type="time" class="form-control" id="hora_venda" name="hora_venda" value="<?=date("H:i")?>" required>
            </div>
            <input type="hidden" name="adicionar">
            <button type="submit" class="btn btn-primary">Adicionar</button>
            <button type="button" class="btn btn-danger" onclick="location.href = 'vendas.php'">Cancelar</button>
        </form>
        </div>
    </body>
</html>