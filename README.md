# CodeIgniter 4  Integration PagSeguro API

Em desenvolvimento.

#### Funcionalidades

- Geração de boleto pela API do PagSeguro
- Callback ao atualizar algum status de pagamento
- Validação com um código de referência unico
- Envio de confirmação por e-mail do status do pedido

#### Em desenvolvimento

- Boleto em Lightbox em um modal

#### A fazer

- Tratamento de erros do PagSeguro
- Utilizar o cURL do ci4
- Finalização de campos do formulário
- Pagamento por cartão de crédito

#### Estrutura:
| Tipo | Nome | Razão |
| ------ | ------ | ------ |
| Controller | Home.php | Listagem das transações |
| Controller | Notificação.php | Receber a requisição do PagSeguro |
| Controller | Pagar.php | Enviar as requisições ao PagSeguro |
| Controller | Transações.php | Comunicação o banco de dados |
| Helper | pagamento.php | Conversão de valores para o cliente |
| Model | Transações.php | Operações no banco de dados |

#### Utilização:
- A documentação pode ser acessar através do link [Documentação PagSeguro](https://dev.pagseguro.uol.com.br/docs "Documentação PagSeguro")
- Criar uma conta no [PagSeguro Sandbox](https://sandbox.pagseguro.uol.com.br/ "PagSeguro Sandbox")

Caso dê algum erro de instalação do CI4 com o PHP, siga estes passos [Instalação PHP](https://github.com/matheuscastroweb/ci4-crud/blob/master/README.md "Instalação PHP") 

Alterar o email de teste disponibizado no PagSeguro `./Views/home` no campo `email`. 

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

Para o envio de e-mails basta alterar as para as respectivas.

```php
#--------------------------------------------------------------------
# Config Mail
#--------------------------------------------------------------------
mail.host   = host
mail.user   = user
mail.pass   = pass
mail.port   = port
```

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

