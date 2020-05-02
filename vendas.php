<?php
    ini_set('display_errors', 1); 
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    require_once 'src/models/Venda.php';

    if(isset($_GET['err'])){
        switch($_GET['err']){
            case 1:
                $feedback = false;
                $msg = "Impossível adicionar uma venda. Para que isso seja possível, é necessário que existam pelo menos um vendedor e um produto. Para prosseguir, adicione um vendedor e um produto pelo menos.";
                break;
        }
    }
    if(isset($_POST["adicionar"]) && isset($_POST["id_vendedor"]) && isset($_POST["id_produto"]) && isset($_POST["valor"]) && 
        isset($_POST["dia_venda"]) && isset($_POST["hora_venda"])){

        $venda = new Venda();
        $venda->setIdVendedor($_POST["id_vendedor"]);
        $venda->setIdProduto($_POST["id_produto"]);
        $venda->setValor($_POST["valor"]);
        $venda->setObservacao($_POST["observacao"]);
        $venda->setDataVenda(date("Y-m-d H:i:s", strtotime($_POST["hora_venda"]." ".$_POST["dia_venda"])));

        $feedback = $venda->create();

        if($feedback){
            $msg = "Nova venda adicionada com sucesso!";
        }else{
            $msg = "Houve um erro ao tentar adicionar uma nova venda. Por favor, tente novamente, Se o erro persistir, contate o desenvolvedor.";
        }
    }

    if(isset($_GET["action"]) && strcmp($_GET["action"],"del") == 0 &&  isset($_GET["id"])){
        $venda = new Venda();
        $venda->setId($_GET["id"]);
        $feedback = $venda->delete();

        if($feedback){
            $msg = "Venda excluída com sucesso!";
        }else{
            $msg = "Houve um erro ao tentar excluir esta venda. Por favor, tente novamente, Se o erro persistir, contate o desenvolvedor.";
        }
    }

    $totalVendas = Venda::total();
    $totalPaginas = ceil($totalVendas/10);

    $pagina = $_GET['p'] ?? 1;

    if( $pagina > $totalPaginas ){
        $pagina = 1;
    }

    $foreing_data = [
        [
            "model" => "vendedor",
            "fk" => "id_vendedor",
            "pk" => "id",
            "table" => "vendedores",
            "columns" => ["nome", "sobrenome"]
        ],
        [
            "model" => "produto",
            "fk" => "id_produto",
            "pk" => "id",
            "table" => "produtos",
            "columns" => ["nome"]
        ]
    ];

    if($totalVendas > 0){
        $vendas = Venda::list(null,null,0,$pagina*10-10,10,$foreing_data);
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
                <li class="nav-item">
                    <a class="nav-link" href="vendedores.php">Vendedores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="vendas.php">Vendas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="relatorios.php">Relatórios</a>
                </li>
            </ul>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-sm text-center">
                    <h1>Vendas</h1>
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
                    <button type="button" class="btn btn-outline-primary" onclick="location.href = 'adicionar_venda.php'">Adicionar nova venda</button>
                </div>
            </div>
            <div class="row">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Produto</th>
                            <th>Vendedor</th>
                            <th>Valor</th>
                            <th>Observação</th>
                            <th>Data da venda</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($totalVendas == 0){ ?>
                            <tr>
                                <td class="table-info" colspan="7">Ainda não há vendas. Adicione uma venda clicando <a href="adicionar_venda.php">aqui</a>. </td>
                            </tr> 
                        <?php }else{ ?>
                            <?php foreach($vendas as $venda){ ?>
                                
                                <tr>
                                    <td><?=$venda["id"]?></td>
                                    <td><?=$venda["produto_nome"]?></td>
                                    <td><?=$venda["vendedor_nome"]." ".$venda["vendedor_sobrenome"]?></td>
                                    <td><?=str_replace(".",",",money_format("R$ %n",$venda["valor"]))?></td>
                                    <td><?=$venda["observacao"]?></td>
                                    <td><?=date("d/m/Y H:i",strtotime($venda["data_venda"]))?></td>
                                    <td>
                                        <a href="editar_venda.php?id=<?=$venda["id"]?>">Editar</a>
                                        <a href="vendas.php?action=del&id=<?=$venda["id"]?>">Excluir</a>
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
                            echo '<a href="vendas.php?p='.( $pagina - 1 ).'">Anterior</a>';
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
                            echo '<a href="vendas.php?p='.( $pagina + 1 ).'">Próxima</a>';
                        } 
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>