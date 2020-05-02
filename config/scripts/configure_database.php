<?php

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require(__DIR__."/../../src/models/Database.php");


$db = new Database();

$db->complex_query("ALTER ".Database::MYSQL_DBNAME." gerenciador CHARSET = UTF8 COLLATE = utf8_general_ci;");

$r = $db->complex_query("CREATE TABLE vendedores (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    sobrenome VARCHAR(255) NOT NULL,
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);");

if(!$r){
    echo "Falha ao criar a tabela vendedores (talvez ela já exista)";
    exit();
}

$r = $db->complex_query("CREATE TABLE produtos (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    valor FLOAT NOT NULL,
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);");

if(!$r){
    echo "Falha ao criar a tabela produtos (talvez ela já exista)";
    exit();
}

$r = $db->complex_query("CREATE TABLE vendas (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_vendedor INT(6) UNSIGNED NOT NULL,
    id_produto INT(6) UNSIGNED NOT NULL,
    valor FLOAT NOT NULL,
    observacao VARCHAR(255),
    data_venda TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_venda_vendedor FOREIGN KEY (id_vendedor) REFERENCES vendedores (id),
    CONSTRAINT fk_venda_produto FOREIGN KEY (id_produto) REFERENCES produtos (id) ON DELETE CASCADE
);");

if(!$r){
    echo "Falha ao criar a tabela vendas (talvez ela já exista ou não exista uma tabela de vendedores/produtos)";
    exit();
}

echo "Tabelas configuradas";



?>