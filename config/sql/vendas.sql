CREATE TABLE vendas (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_vendedor INT(6) UNSIGNED NOT NULL,
    id_produto INT(6) UNSIGNED NOT NULL,
    valor FLOAT NOT NULL,
    observacao VARCHAR(255),
    data_venda TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_venda_vendedor FOREIGN KEY (id_vendedor) REFERENCES vendedores (id),
    CONSTRAINT fk_venda_produto FOREIGN KEY (id_produto) REFERENCES produtos (id) ON DELETE CASCADE
);