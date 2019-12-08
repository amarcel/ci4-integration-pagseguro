# CodeIgniter 4  Integration PagSeguro API
![](https://img.shields.io/github/issues-raw/matheuscastroweb/ci4-integration-pagseguro) ![](https://img.shields.io/github/contributors/matheuscastroweb/ci4-integration-pagseguro) ![](https://img.shields.io/github/stars/matheuscastroweb/ci4-integration-pagseguro) 

### Em desenvolvimento.

## Conteúdo:

- [Features](#features "Features")
- [Estrutura library](#estrutura-library "Estrutura library")
- [Utilização](#utiliza%C3%A7%C3%A3o "Utilização")
- [Funcionamento](#funcionamento "Funcionamento")
- [Banco de dados](#banco-de-dados-utilizado "Banco de dados") 
- [Projeto completo no CI4](https://github.com/matheuscastroweb/ci4-integration-pagseguro/tree/master "Projeto completo no CI4") 
## Features:

- Geração de boleto pela API
- Pagamento por cartão de crédito
- Callback ao atualizar algum status de pagamento
- Validação com um código de referência unico
- Envio de confirmação por e-mail do status do pedido
- Boleto em Lightbox em um modal
- Loader para aguardar requisição de pagamento
- Logs a cada status da transação

## Estrutura Library:
| Função | Razão |
| ------ | ------ |
| getSession | Gerar uma sessão de pagamento obrigatória| 
| requestNotification | Receber notificação do PagSeguro de alteração de status |
| paymentBillet | Gerar pagamento por boleto bancário |
| paymentCard | Gerar pagamento por cartão de crédito | 
| store | Adicionar uma transação ao banco de dados | 
| edit | Editar um status de transação no banco de dados |
| notifyStatus | Envia notificação por e-mail sobre o status do pedido | 


## Utilização:

 Config banco de dados
 Acessar /listagem
 Colocar dados no config/PagSeguro

```php
use App\Libraries\PagSeguro;

$pagseguro = new PagSeguro();

//Controller Sessao - Pegar sessão
$pagseguro->getSession();

//Controller Notificacao - Receber requisição do PagSeguro para atualizar status
$pagseguro->requestNotification($request);

//Controller Pagar - Pagamento por boleto
$pagseguro->paymentBillet($request);

//Controller pagar - Pagamento por cartão de crédito
$pagseguro->paymentCard($request);
```
 

2.  Criar uma conta no [PagSeguro Sandbox](https://sandbox.pagseguro.uol.com.br/ "PagSeguro Sandbox"). A documentação pode ser acessar através do link [Documentação PagSeguro](https://dev.pagseguro.uol.com.br/docs "Documentação PagSeguro"). Altere `Config/PagSeguro.php` para acessar a URL de produção do PagSeguro quando finalizado o projeto.

```php
#-----------------------------
# API PagSeguro - Alterar no .env
#-----------------------------
api.email	= seu_email
api.token	= seu_token
```

3. Alterar o email de teste disponibizado no PagSeguro `./Views/home` no campo `email` para utilizar em modo desenvolvimento do PagSeguro e fazer os pagamentos. 

4. Para o envio de e-mails basta alterar as para as respectivas. Em padrão o campo `mail.using` vem como `false`, para realizar o envio de e-mail . O serviço de e-mail utilizado foi o [Mailtrap](https://mailtrap.io/ "Mailtrap").

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

5. Para utilizar o módulo de notificação em localhost, basta acessar o PagSeguro e simular uma troca de status.

6. Bibliotecas necessárias

```php
#-----------------------------
# Extensões necessárias do php.ini
#-----------------------------
extension=mbstring
extension=mysqli
extension=curl
extension=openssl
```

> **OBS.:** Caso a base url não seja localhost:8080, configurar neste documentos para gerar as sessões `assets/js/sessao.js `

## Funcionamento:
Testes realizados em sandbox com geração de nome e CPF inválidos somentes para testes. 

### Listagem de todas transações:

![Listagem](https://user-images.githubusercontent.com/45601574/70375547-a4350a80-18dd-11ea-8999-5a4b33df7d44.png)

### Pagamento cartão:

![Pagamento-cartao](https://user-images.githubusercontent.com/45601574/70101423-90568380-1613-11ea-9f03-adfea52c4329.gif)

### Pagamento boleto:

![Pagamento](https://user-images.githubusercontent.com/45601574/70101422-90568380-1613-11ea-9bb8-da7de6576753.gif)

## Banco de dados utilizado:
Utilizar a migration `AddTransacao` pela CLI conforme abaixo ou adicionar manualmente com o código SQL abaixo. Veja aqui como utilizar as [Migrations do CI4](https://codeigniter4.github.io/userguide/dbmgmt/migration.html#command-line-tools "Migrations do CI4").


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

