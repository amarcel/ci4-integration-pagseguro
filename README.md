# CodeIgniter 4  Integration PagSeguro API

Em desenvolvimento.

#### A fazer

- Tratamento de erros do PagSeguro
- Boleto em Lightbox em um modal
- Fazer retorno de transação
- Utilizar o cURL do ci4
- Pagamento por cartão de crédito/débito

#### Utilização:
Criar uma conta no [PagSeguro Sandbox](https://sandbox.pagseguro.uol.com.br/ "PagSeguro Sandbox")
A documentação pode ser acessar através do link [Documentação PagSeguro](https://dev.pagseguro.uol.com.br/docs "Documentação PagSeguro")

Alterar os parâmetros no `./env`: 

```php
#-----------------------------
# API PagSeguro
#-----------------------------
api.mode	= development
api.email	= seu_email
api.token	= seu_token
```
Ao alterar o `api.mode: ` para production acessará a URL de produção do PagSeguro.

Banco de dados utilizado:

```sql
CREATE OR REPLACE DATABASE ci4_integration_pagseguro;
```

```sql
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
deleted_at DATETIME );
```

