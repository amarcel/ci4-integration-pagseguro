# CodeIgniter 4  integration pagseguro API

Em desenvolvimento.

#### A fazer

- Mudança automática de Ambiente de desenvolvimento
- Tratamento de erros do PagSeguro
- Boleto em Lightbox em um modal
- Criar banco de dados de transações
- Fazer retorno de transação
- Utilizar o cURL do ci4
- Pagamento por cartão de crédito/débito

Utilização:

Alterar os parâmetros no env, mudar para .env


Databases:

CREATE DATABASE ci4_integration_pagseguro;

CREATE OR REPLACE TABLE transacao (
id INT PRIMARY KEY AUTO_INCREMENT,
id_pedido INT,
id_cliente INT, 
codigo_transacao VARCHAR(255),
tipo_transacao TINYINT(1),
status_transacao VARCHAR(45),
valor_transacao DOUBLE,
url_boleto VARCHAR(255),
created_at DATETIME,
updated_at DATETIME,
deleted_at DATETIME
);

