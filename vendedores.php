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
                        <tr>
                            <td>00001</td>
                            <td>João</td>
                            <td>Paulo</td>
                            <td>
                                <a href="editar_vendedor.php?id=1">Editar</a>
                                <a href="excluir_vendedor.php?id=1">Excluir</a>
                            </td>
                        </tr> 
                        <tr>
                            <td>00001</td>
                            <td>João</td>
                            <td>Paulo</td>
                            <td>
                                <a href="editar_vendedor.php?id=1">Editar</a>
                                <a href="excluir_vendedor.php?id=1">Excluir</a>
                            </td>
                        </tr> 
                        <tr>
                            <td>00001</td>
                            <td>João</td>
                            <td>Paulo</td>
                            <td>
                                <a href="editar_vendedor.php?id=1">Editar</a>
                                <a href="excluir_vendedor.php?id=1">Excluir</a>
                            </td>
                        </tr> 
                        <tr>
                            <td>00001</td>
                            <td>João</td>
                            <td>Paulo</td>
                            <td>
                                <a href="editar_vendedor.php?id=1">Editar</a>
                                <a href="excluir_vendedor.php?id=1">Excluir</a>
                            </td>
                        </tr> 
                    </tbody>
                </table>
            </div>
            <div class="row text-center">
                <div class="col-sm">
                    <a href="">Anterior</a>
                </div>
                <div class="col-sm">
                    1/10
                </div>
                <div class="col-sm">
                    <a href="">Próximo</a>
                </div>
            </div>
        </div>
    </body>
</html>