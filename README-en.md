# CodeIgniter 4  Integration PagSeguro API

### Under development.

## Content:

- [Structure](#estrutura "Structure")
- [Use](#utiliza%C3%A7%C3%A3o "Use")
- [Operation](#funcionamento "Operation")
- [Database used](#banco-de-dados-utilizado "Database used")

## Features:

- Boleto Generation by API
- Credit Card Payment
- Callback when updating some payment status
- Validation with a unique reference code
- Email confirmation of order status
- Lightbox ticket in a modal
- Loader to wait for payment request
- Logs at each transaction status

## Structure:
| Type | First name | Reason |
| ------ | ------ | ------ |
| Controller | Home.php | Status to check variables |
| Controller | Sessao.php | Responsible for generating the payment sections |
| Controller | Listagem.php | Transaction Listing |
| Controller | Notificacao.php | Receive the request from PagSeguro |
| Controller | Email.php | Email Update Status |
| Controller | Pagar.php | Send requests to PagSeguro |
| Controller | Transacoes.php | Communication the database |
| Helper | pagamento_helper.php | Customer value conversion |
| Model | TransacoesModel.php | Database Operations |


## Use:

1. Follow the installation of PHP. If you get CI4 installation errors with PHP, follow these steps [PHP installation](https://github.com/matheuscastroweb/ci4-crud/blob/master/README.md "PHP installation"). 

```php
#-----------------------------
# Extensões necessárias do php.ini
#-----------------------------
extension=mbstring
extension=mysqli
extension=curl
```

2.  Create an account on [PagSeguro Sandbox](https://sandbox.pagseguro.uol.com.br/ "PagSeguro Sandbox"). Documentation can be accessed through the link [Documentação PagSeguro](https://dev.pagseguro.uol.com.br/docs "Documentação PagSeguro"). Changing `api.mode` to` production` will access the production URL of PagSeguro.


```php
#-----------------------------
# API PagSeguro - Alterar no .env
#-----------------------------
api.mode	= development
api.email	= seu_email
api.token	= seu_token
```

3. Change the test email provided in PagSeguro `. / Views / home` in the` email` field to use in PagSeguro development mode and make payments.

4. To send emails just change the ones to the respective ones. By default the `mail.using` field is set to` false` for sending email. The email service used was the [Mailtrap](https://mailtrap.io/ "Mailtrap").

```php
#--------------------------------------------------------------------
# Config Mail
#--------------------------------------------------------------------
mail.using   = false
mail.host    = host
mail.user    = user
mail.pass    = pass
mail.port    = port
```

5.To use the notification module on localhost, simply access PagSeguro and simulate a status exchange.

> **OBS.:** Always when updating any .env parameter restart the php server.
> **OBS.:** If url base is not localhost: 8080, configure in this documents to generate sessions `public/assets/js/sessao.js `

6. Verify that all PagSeguro parameters are set to `YES`.

![Home](https://user-images.githubusercontent.com/45601574/70171446-7bc6c980-16ad-11ea-9985-342c2cd936b2.png)


## Operation:
Sandbox tests with only invalid name and CPF generation for testing.

### Listing of all transactions:

![Listagem](https://user-images.githubusercontent.com/45601574/70171703-0b6c7800-16ae-11ea-8661-7ead0f8a0827.png)

### Card payment:

![Pagamento-cartao](https://user-images.githubusercontent.com/45601574/70101423-90568380-1613-11ea-9f03-adfea52c4329.gif)

### Bill Payment:

![Pagamento](https://user-images.githubusercontent.com/45601574/70101422-90568380-1613-11ea-9bb8-da7de6576753.gif)

## Database used:
Use CLI `AddTransacao` migration as below or manually add with SQL code below. Here's how to use the [Migrations do CI4](https://codeigniter4.github.io/userguide/dbmgmt/migration.html#command-line-tools "Migrations do CI4").


```php
#--------------------------------------------------------------------
# Comandos úteis para utilização das migrations
#--------------------------------------------------------------------

#Criação das migrations
php spark migrate:create

#Rodar as migrations
php spark migrate

```

```sql
CREATE OR REPLACE DATABASE ci4_integration_pagseguro;
```

```sql
USE ci4_integration_pagseguro;

CREATE OR REPLACE TABLE transacao (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_pedido INT NOT NULL,
    id_cliente INT NOT NULL, 
    codigo_transacao VARCHAR(255) NOT NULL,
    tipo_transacao TINYINT(1) NOT NULL,
    referencia_transacao VARCHAR(255) NOT NULL,
    status_transacao VARCHAR(45)  NOT NULL,
    valor_transacao DOUBLE  NOT NULL,
    url_boleto VARCHAR(255),
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME DEFAULT NULL 
    );
```

