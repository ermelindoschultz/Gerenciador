<?php
    ini_set('display_errors', 1); 
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    require_once 'src/models/Vendedor.php';
    require_once 'src/models/Produto.php';
    require_once 'src/models/Venda.php';  
    
    $totalVendedores = Vendedor::total();
    $totalProdutos = Produto::total();
    $totalVendas = Venda::total();

    $vendedores = Vendedor::list(["id","nome","sobrenome"]);
    $produtos = Produto::list(["id","nome"]);

?>
<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
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
                            <p class="card-text"> Faturamento total atual: R$ 20000,00 </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <h1>Faturamento total por mês</h1>
                    <div class="row">
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Ano </span>
                                </div>
                                <select class="form-control">
                                    <option>2020</option>
                                    <option>2019</option>
                                    <option>2018</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Comparar com: </span>
                                </div>
                                <select class="form-control">
                                    <option>Não comparar</option>
                                    <option>2019</option>
                                    <option>2018</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <canvas id="faturamento" width="80%" height="30"></canvas>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <h1>Vendas por produto</h1>
                    <div class="row">
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Produto </span>
                                </div>
                                <select class="form-control">
                                    <option>Caixa</option>
                                    <option>Bola</option>
                                    <option>Mamão</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Comparar com: </span>
                                </div>
                                <select class="form-control">
                                    <option>Não comparar</option>
                                    <option>Caixa</option>
                                    <option>Bola</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <canvas id="vendasPorProduto" width="80%" height="30"></canvas>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <h1>Faturamento por produto</h1>
                    <div class="row">
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Produto </span>
                                </div>
                                <select class="form-control">
                                    <option>Caixa</option>
                                    <option>Bola</option>
                                    <option>Mamão</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Comparar com: </span>
                                </div>
                                <select class="form-control">
                                    <option>Não comparar</option>
                                    <option>Caixa</option>
                                    <option>Bola</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <canvas id="faturamentoPorProduto" width="80%" height="30"></canvas>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <h1>Vendas por vendedor</h1>
                    <div class="row">
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Vendedor </span>
                                </div>
                                <select class="form-control">
                                    <option>Du</option>
                                    <option>Dudu</option>
                                    <option>Edu</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Comparar com: </span>
                                </div>
                                <select class="form-control">
                                    <option>Não comparar</option>
                                    <option>Dudu</option>
                                    <option>Edu</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <canvas id="vendasPorVendedor" width="80%" height="30"></canvas>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <h1>Faturamento por vendedor</h1>
                    <div class="row">
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Vendedor </span>
                                </div>
                                <select class="form-control">
                                    <option>Du</option>
                                    <option>Dudu</option>
                                    <option>Edu</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Comparar com: </span>
                                </div>
                                <select class="form-control">
                                    <option>Não comparar</option>
                                    <option>Dudu</option>
                                    <option>Edu</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <canvas id="faturamentoPorVendedor" width="80%" height="30"></canvas>
                </div>
            </div>
        </div>
        
        
    </body>
</html>