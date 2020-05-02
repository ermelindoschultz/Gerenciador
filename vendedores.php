<?php
    ini_set('display_errors', 1); 
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    require_once 'src/models/Vendedor.php';

    if(isset($_POST["adicionar"]) && isset($_POST["nome"]) && isset($_POST["sobrenome"])){
        $vendedor = new Vendedor($_POST["nome"],$_POST["sobrenome"]);
        $feedback = $vendedor->create();
        if($feedback){
            $msg = "Novo vendedor cadastrado com sucesso!";
        }else{
            $msg = "Houve um erro ao tentar adicionar um novo vendedor. Por favor, tente novamente, Se o erro persistir, contate o desenvolvedor.";
        }
    }

    if(isset($_GET["action"]) && strcmp($_GET["action"],"del") == 0 &&  isset($_GET["id"])){
        $vendedor = new Vendedor();
        $vendedor->setId($_GET["id"]);
        $feedback = $vendedor->delete();

        if($feedback){
            $msg = "Vendedor excluído com sucesso!";
        }else{
            $msg = "Houve um erro ao tentar excluir este vendedor. Por favor, tente novamente, Se o erro persistir, contate o desenvolvedor.";
        }
    }

    $vendedor = new Vendedor();

    $totalVendedores = $vendedor->total();
    $totalPaginas = ceil($totalVendedores/10);

    $pagina = $_GET['p'] ?? 1;

    if( $pagina > $totalPaginas ){
        $pagina = 1;
    }

    if($totalVendedores > 0){
        $vendedores = $vendedor->list(null,null,0,$pagina*10-10,10);
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
                    <h1>Vendedores</h1>
                </div>
            </div>
        </div>
        <div class="container">
            <?php if(!empty($msg)){ ?>
                <div class="row alert <?=($feedback)? "alert-success" :"alert-danger"; ?> ">
                    <?=$msg;?>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-sm">
                    <button type="button" class="btn btn-outline-primary" onclick="location.href = 'adicionar_vendedor.php'">Adicionar novo vendedor</button>
                </div>
            </div>
            <div class="row">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Sobrenome</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($totalVendedores == 0){ ?>
                            <tr>
                                <td class="table-info" colspan="4">Ainda não há vendedores. Adicione um vendedor clicando <a href="adicionar_vendedor.php">aqui</a>. </td>
                            </tr> 
                        <?php }else{ ?>
                            <?php foreach($vendedores as $vendedor){ ?>
                                
                                <tr>
                                    <td><?=$vendedor["id"]?></td>
                                    <td><?=$vendedor["nome"]?></td>
                                    <td><?=$vendedor["sobrenome"]?></td>
                                    <td>
                                        <a href="editar_vendedor.php?id=<?=$vendedor["id"]?>">Editar</a>
                                        <a href="vendedores.php?action=del&id=<?=$vendedor["id"]?>">Excluir</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="row text-center">
                <div class="col-sm">
                    <?php 
                        if($pagina > 1){ 
                            echo '<a href="vendedores.php?p='.( $pagina - 1 ).'">Anterior</a>';
                        } 
                    ?>
                </div>
                <div class="col-sm">
                    <?php if($totalPaginas > 0){ ?>
                        <?=$pagina."/".$totalPaginas?>
                    <?php } ?>
                </div>
                <div class="col-sm">
                    <?php 
                        if($pagina < $totalPaginas){ 
                            echo '<a href="vendedores.php?p='.( $pagina + 1 ).'">Próxima</a>';
                        } 
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>