# Gerenciador

Este repositório contém um sistema completo simples para gerenciamento de vendas utilizando PHP puro. Foi desenvolvido como parte do processo seletivo da [Commcepta Design](http://www.commcepta.com.br/). 

# Dependências

Este sistema usa PHP >= 7.2 e MySQL 5.7.

# Instalação

Este sistema foi construído e testado em ambiente Linux. As instruções a seguir são baseadas, portanto, em Linux.

Mova a pasta para um diretório na qual seu servidor tenha acesso aos arquivos *.php na raiz. Por exemplo, se você utiliza o servidor Apache, basta mover os arquivos para o diretório raiz do servidor.

```bash
mv /caminho/para/o/Gerenciador /raiz/do/servidor
```

# Configuração

Antes de acessar o sistema, é necessário configurar o banco de dados. 

Primeiro, altere o arquivo `config/database/database_constants.php`com as informações de acesso ao seu banco de dados.

Depois, há duas formas de configurar as tabelas

1. Você pode adiciona-las manualmente executando as queries SQL contidas nos arquivos `config/sql/\*.sql`.
2. Você pode executar o arquivo `config/scripts/configure_database.php`

```bash
php config/script/configure_database.php
```
Após estes passos, o sistema estará funcional.

Você pode ainda gerar um conjunto aleatório de dados de teste executando o arquivo `tests/automated_tests`:

```bash
php tests/automated_tests.php
```

# Estrutura de diretórios
```bash
.                               # Contém as _views_ do sistema.        
├── src                         # Contém classes e scripts de manipulação de dados.                    
│   ├── ajax                    # Contém scripts de resposta à chamadas Ajax.
│   ├── models                  # Contém classes de manipulação de dados.          
├── js                          # Contém scripts Javascript.
├── css                         # Contém arquivos de estilização CSS.
├── tests                       # Contém scripts para automatizar testes no sistema.
├── config                      # Contém arquivos de configuração.
│   ├── database                # Contém arquivos com informações de acesso ao Banco de Dados.
│   ├── scripts                 # Contém scripts diversos para configuração do sistema. 
│   ├── sql                     # Contém arquivos SQL com as tabelas do sistema.     
└── README.md                   # Este arquivo.
```

## Este software foi construído sobre o ombro de gigantes!

* [Bootstrap](https://getbootstrap.com/) - The most popular HTML, CSS, and JS library in the world
* [Jquery](https://jquery.com/) e [Jquery maskMoney Plugin](https://plugins.jquery.com/maskMoney/)
* [Chart.js](https://www.chartjs.org/)




