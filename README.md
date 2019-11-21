# CodeIgniter 4  Integration PagSeguro API

Em desenvolvimento.

#### Funcionalidades

- Geração de boleto pela API do PagSeguro
- Callback ao atualizar algum status de pagamento

#### A fazer

- Tratamento de erros do PagSeguro
- Boleto em Lightbox em um modal
- Utilizar o cURL do ci4
- Pagamento por cartão de crédito/débito
- Alterar o REF para um HASH único

#### Estrutura:
| Tipo | Nome | Razão |
| ------ | ------ | ------ |
| Controller  | Home  | Listagem das transações |
| Controller | Notificação  | Receber a requisição do PagSeguro |
|  Controller | Pagar  | Enviar as requisições ao PagSeguro |
| Controller  | Transações  | Comunicação o banco de dados |
| Helper  | pagamento  | Conversão de valores para o cliente |
| Model  | Transações  | Operações no banco de dados |

#### Utilização:
A documentação pode ser acessar através do link [Documentação PagSeguro](https://dev.pagseguro.uol.com.br/docs "Documentação PagSeguro")

Criar uma conta no [PagSeguro Sandbox](https://sandbox.pagseguro.uol.com.br/ "PagSeguro Sandbox")

 Alterar os parâmetros no `./env`: 

```php
#-----------------------------
# API PagSeguro
#-----------------------------
api.mode	= development
api.email	= seu_email
api.token	= seu_token
```
Ao alterar o `api.mode: ` para `production` acessará a URL de produção do PagSeguro.

Banco de dados utilizado:

```sql
CREATE OR REPLACE DATABASE ci4_integration_pagseguro;
```

```sql
CREATE OR REPLACE TABLE transacao (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_pedido INT NOT NULL,
    id_cliente INT NOT NULL, 
    codigo_transacao VARCHAR(255) NOT NULL,
    tipo_transacao TINYINT(1) NOT NULL,
    referencia_transacao VARCHAR(255) NOT NULL,
    status_transacao VARCHAR(45)  NOT NULL,
    valor_transacao DOUBLE  NOT NULL,
    url_boleto VARCHAR(255)  NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME DEFAULT NULL 
    );
```

