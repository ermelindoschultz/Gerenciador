# Gerenciador

Este repositório contém um sistema completo simples para gerenciamento de vendas utilizando PHP puro. Foi desenvolvido como parte do processo seletivo da Commcepta Design. 

# Dependências

Este sistema usa PHP >= 7 e MySQL 5.7.

# Instalação

Este sistema foi construído e testado em ambiente Linux. As instruções a seguir são baseadas, portanto, em Linux.

Mova a pasta para um diretório na qual seu servidor tenha acesso aos arquivos *.php na raiz. Por exemplo, se você utiliza o servidor Apache, basta mover os arquivos para o diretório raiz do servidor.

```bash
mv /caminho/para/o/Gerenciador /raiz/do/servidor
```

# Configuração

Antes de acessar o sistema, é necessário configurar os bancos de dados. 

Primeiro, configure o arquivo **config/database/database_constants.php** com as informações de acesso ao seu banco de dados.

Depois, há duas formas de configurar as tabelas

1. Você pode adiciona-las manualmente executando as queries SQL contidas nos arquivos **config/sql/\*.sql**.
2. Você pode executar o arquivo **config/scripts/configure_database.php**:

```bash
php config/script/configure_database.php
```
Após estes passos, o sistema estará funcional.

Você pode ainda gerar um conjunto aleatório de dados de teste executando o arquivo **tests/automated_tests**:

```bash
php tests/automated_tests.php
```

# Estrutura de diretórios



## Construído com

* [Dropwizard](http://www.dropwizard.io/1.0.2/docs/) - The web framework used
* [Maven](https://maven.apache.org/) - Dependency Management
* [ROME](https://rometools.github.io/rome/) - Used to generate RSS Feeds.


