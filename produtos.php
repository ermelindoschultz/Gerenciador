<?php
   ini_set('display_errors', 1); 
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL);
   
   require_once 'src/models/Produto.php';

   if(isset($_POST["adicionar"]) && isset($_POST["nome"]) && isset($_POST["valor"])){
       $produto = new Produto($_POST["nome"],$_POST["valor"]);
       $feedback = $produto->create();
       if($feedback){
           $msg = "Novo produto cadastrado com sucesso!";
       }else{
           $msg = "Houve um erro ao tentar adicionar um novo produto. Por favor, tente novamente, Se o erro persistir, contate o desenvolvedor.";
       }
   }

   if(isset($_GET["action"]) && strcmp($_GET["action"],"del") == 0 &&  isset($_GET["id"])){
       $produto = new Produto();
       $produto->setId($_GET["id"]);
       $feedback = $produto->delete();

       if($feedback){
           $msg = "Produto excluído com sucesso!";
       }else{
           $msg = "Houve um erro ao tentar exclui este produto. Por favor, tente novamente, Se o erro persistir, contate o desenvolvedor.";
       }
   }
   $totalProdutos = Produto::total();
   $totalPaginas = ceil($totalProdutos/10);

   $pagina = $_GET['p'] ?? 1;

   if( $pagina > $totalPaginas || !is_numeric($pagina)){
       $pagina = 1;
   }

   if($totalProdutos > 0){
       $produtos = Produto::list(null,null,0,$pagina*10-10,10);
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
                    <h1>Produtos</h1>
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
                    <button type="button" class="btn btn-outline-primary" onclick="location.href = 'adicionar_produto.php'">Adicionar novo produto</button>
                </div>
            </div>
            <div class="row">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Valor</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($totalProdutos == 0){ ?>
                            <tr>
                                <td class="table-info" colspan="4">Ainda não há produtos. Adicione um produto clicando <a href="adicionar_produto.php">aqui</a>. </td>
                            </tr> 
                        <?php }else{ ?>
                            <?php foreach($produtos as $produto){ ?>
                                <tr>
                                    <td><?=$produto["id"]?></td>
                                    <td><?=$produto["nome"]?></td>
                                    <td><?=str_replace(".",",",money_format("R$ %n",$produto["valor"]))?></td>
                                    <td>
                                        <a href="editar_produto.php?id=<?=$produto["id"]?>">Editar</a>
                                        <a href="produtos.php?action=del&id=<?=$produto["id"]?>">Excluir</a>
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
                            echo '<a href="produtos.php?p='.( $pagina - 1 ).'">Anterior</a>';
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
                            echo '<a href="produtos.php?p='.( $pagina + 1 ).'">Proximo</a>';
                        } 
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>