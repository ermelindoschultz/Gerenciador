<?php
    /**
     * Eu documentei este relatório!
     */
    require_once 'src/models/DataAnalysis.php';
    require_once 'src/models/Vendedor.php';
    require_once 'src/models/Produto.php';
    require_once 'src/models/Venda.php';  
    
    $analyst = new DataAnalysis();
    $vendedor = new Vendedor();
    $produto = new Produto();
    $venda = new Venda();

    $totalVendedores = $vendedor->total();
    $totalProdutos = $produto->total();
    $totalVendas = $venda->total();

    $vendedores = $vendedor->list(["id","nome","sobrenome"]);
    $produtos = $produto->list(["id","nome"]);

    $vendaMaisAntiga = $venda->older();
    $vendaMaisNova = $venda->younger();

    if(!empty($vendaMaisAntiga)){
        $primeiroAno = date("Y",strtotime($vendaMaisAntiga["data_venda"]));
        $ultimoAno = date("Y",strtotime($vendaMaisNova["data_venda"]));
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/chart.min.js"></script>
        <script type="text/javascript" src="js/visualization.js"></script>
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
                <li class="nav-item">
                    <a class="nav-link" href="vendas.php">Vendas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="relatorios.php">Relatórios</a>
                </li>
            </ul>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-sm text-center">
                    <h1>Relatórios</h1>
                </div>
            </div>
        </div>
        <?php if(empty($vendedores)){ ?>
            <div class="container">
                <div class="row alert alert-info">
                <p>Para que seja possível gerar relatórios, é necessário que você tenha adicionado ao menos um vendedor e um produto. Para adicionar adicionar um vendedor clique <a href="adicionar_vendedor.php">aqui</a>. Se quiser adicionar um produto, clique <a href="adicionar_produto.php"> aqui</a>.</p>
                </div>
            </div>
        <?php }else { ?>
            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <h1>Visão geral</h1>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="card text-center no_border">
                            <svg class="bi bi-collection-fill icone_inicial" width="10em" height="10em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <rect width="16" height="10" rx="1.5" transform="matrix(1 0 0 -1 0 14.5)"/>
                                <path fill-rule="evenodd" d="M2 3a.5.5 0 00.5.5h11a.5.5 0 000-1h-11A.5.5 0 002 3zm2-2a.5.5 0 00.5.5h7a.5.5 0 000-1h-7A.5.5 0 004 1z" clip-rule="evenodd"/>
                            </svg>
                            <div class="card-body">
                                <h5 class="card-title"><?=$totalProdutos?> Produtos</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="card text-center no_border">
                            <svg class="bi bi-people-fill icone_inicial" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 100-6 3 3 0 000 6zm-5.784 6A2.238 2.238 0 015 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 005 9c-4 0-5 3-5 4s1 1 1 1h4.216zM4.5 8a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" clip-rule="evenodd"/>
                            </svg>
                            <div class="card-body">
                                <h5 class="card-title"> <?=$totalVendedores?> Vendedores</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="card text-center no_border">
                            <svg class="bi bi-briefcase-fill icone_inicial" width="10em" height="10em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M0 12.5A1.5 1.5 0 001.5 14h13a1.5 1.5 0 001.5-1.5V6.85L8.129 8.947a.5.5 0 01-.258 0L0 6.85v5.65z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M0 4.5A1.5 1.5 0 011.5 3h13A1.5 1.5 0 0116 4.5v1.384l-7.614 2.03a1.5 1.5 0 01-.772 0L0 5.884V4.5zm5-2A1.5 1.5 0 016.5 1h3A1.5 1.5 0 0111 2.5V3h-1v-.5a.5.5 0 00-.5-.5h-3a.5.5 0 00-.5.5V3H5v-.5z" clip-rule="evenodd"/>
                            </svg>
                            <div class="card-body">
                                <h5 class="card-title"> <?=$totalVendas?> Vendas</h5>
                                <p class="card-text"> Faturamento total atual: <?=str_replace(".",",",money_format("R$ %n",$analyst->faturamentoTotal()))?> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($totalVendas > 0){ ?>
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <h1>Faturamento total por mês</h1>
                            <form id="formFaturamentoPorMes">
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Ano </span>
                                            </div>
                                            <select class="form-control" id="anoFaturaPorMes">
                                                <?php for($ano=$ultimoAno; $ano >= $primeiroAno; $ano--){ ?>
                                                    <option value="<?=$ano?>"><?=$ano?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Comparar com: </span>
                                            </div>
                                            <select class="form-control" id="anoCompararFaturaPorMes">
                                                <option>Não comparar</option>
                                                <?php for($ano=$ultimoAno; $ano >= $primeiroAno; $ano--){ ?>
                                                    <option value="<?=$ano?>"><?=$ano?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <canvas id="faturamentoPorMes" width="80%" height="30"></canvas>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <h1>Vendas por produto</h1>
                            <form id="formVendasPorProduto">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Ano </span>
                                        </div>
                                        <select class="form-control" id="anoVendasPorProduto">
                                                <?php for($ano=$ultimoAno; $ano >= $primeiroAno; $ano--){ ?>
                                                    <option value="<?=$ano?>"><?=$ano?></option>
                                                <?php } ?>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Produto </span>
                                        </div>
                                        <select class="form-control" id="idVendasPorProduto">
                                            <?php foreach($produtos as $produto){ ?>
                                                <option value="<?=$produto["id"]?>"><?=$produto["nome"]?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Comparar com: </span>
                                        </div>
                                        <select class="form-control" id="idCompararVendasPorProduto">
                                            <option>Não comparar</option>
                                            <?php foreach($produtos as $produto){ ?>
                                                <option value="<?=$produto["id"]?>"><?=$produto["nome"]?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            </form>
                            <canvas id="vendasPorProduto" width="80%" height="30"></canvas>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <h1>Faturamento por produto</h1>
                            <form id="formFaturamentoPorProduto">
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Ano </span>
                                            </div>
                                            <select class="form-control" id="anoFaturamentoPorProduto">
                                                    <?php for($ano=$ultimoAno; $ano >= $primeiroAno; $ano--){ ?>
                                                        <option value="<?=$ano?>"><?=$ano?></option>
                                                    <?php } ?>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Produto </span>
                                            </div>
                                            <select class="form-control" id="idFaturamentoPorProduto">
                                                <?php foreach($produtos as $produto){ ?>
                                                    <option value="<?=$produto["id"]?>"><?=$produto["nome"]?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Comparar com: </span>
                                            </div>
                                            <select class="form-control" id="idCompararFaturamentoPorProduto">
                                                <option>Não comparar</option>
                                                <?php foreach($produtos as $produto){ ?>
                                                    <option value="<?=$produto["id"]?>"><?=$produto["nome"]?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <canvas id="faturamentoPorProduto" width="80%" height="30"></canvas>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <h1>Vendas por vendedor</h1>
                            <form id="formVendasPorVendedor">
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Ano </span>
                                            </div>
                                            <select class="form-control" id="anoVendasPorVendedor">
                                                    <?php for($ano=$ultimoAno; $ano >= $primeiroAno; $ano--){ ?>
                                                        <option value="<?=$ano?>"><?=$ano?></option>
                                                    <?php } ?>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Vendedor </span>
                                            </div>
                                            <select class="form-control" id="idVendasPorVendedor">
                                                <?php foreach($vendedores as $vendedor){ ?>
                                                    <option value="<?=$vendedor["id"]?>"><?=$vendedor["nome"]." ".$vendedor["sobrenome"]?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Comparar com: </span>
                                            </div>
                                            <select class="form-control" id="idCompararVendasPorVendedor">
                                                <option>Não comparar</option>
                                                <?php foreach($vendedores as $vendedor){ ?>
                                                    <option value="<?=$vendedor["id"]?>"><?=$vendedor["nome"]." ".$vendedor["sobrenome"]?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <canvas id="vendasPorVendedor" width="80%" height="30"></canvas>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <h1>Faturamento por vendedor</h1>
                            <form id="formFaturamentoPorVendedor">
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Ano </span>
                                            </div>
                                            <select class="form-control" id="anoFaturamentoPorVendedor">
                                                    <?php for($ano=$ultimoAno; $ano >= $primeiroAno; $ano--){ ?>
                                                        <option value="<?=$ano?>"><?=$ano?></option>
                                                    <?php } ?>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Vendedor </span>
                                            </div>
                                            <select class="form-control" id="idFaturamentoPorVendedor">
                                                <?php foreach($vendedores as $vendedor){ ?>
                                                    <option value="<?=$vendedor["id"]?>"><?=$vendedor["nome"]." ".$vendedor["sobrenome"]?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Comparar com: </span>
                                            </div>
                                            <select class="form-control" id="idCompararFaturamentoPorVendedor">
                                                <option>Não comparar</option>
                                                <?php foreach($vendedores as $vendedor){ ?>
                                                    <option value="<?=$vendedor["id"]?>"><?=$vendedor["nome"]." ".$vendedor["sobrenome"]?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <canvas id="faturamentoPorVendedor" width="80%" height="30"></canvas>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </body>
</html>