# CodeIgniter 4  Integration PagSeguro API

Em desenvolvimento.

## Funcionalidades

- Geração de boleto pela API do PagSeguro
- Callback ao atualizar algum status de pagamento
- Validação com um código de referência unico
- Envio de confirmação por e-mail do status do pedido
- Boleto em Lightbox em um modal
- Pagamento por cartão de crédito
- Adicionado loader para aguardar requisição de pagamento
- Busca de transação por id adicionado no routes `$routes->get('/(:num)', 'Home::list/$1');`

## A fazer

- Verificar qual bandeira do cartão
- Tratamento de erros do PagSeguro
- Pagamento de cartão com juros
- Colocar do boleto na função de notificar por e-mail 
- Utilizar o cURL do ci4
- Finalização de campos do formulário
- Aviso de vencimento de boleto a 1 dia do vencimento
- Deixar uma view apenas para listagem

## Estrutura:
| Tipo | Nome | Razão |
| ------ | ------ | ------ |
| Controller | Home.php | Listagem das transações |
| Controller | Notificacao.php | Receber a requisição do PagSeguro |
| Controller | Email.php | Enviar status de atualizações por e-mail |
| Controller | Pagar.php | Enviar as requisições ao PagSeguro |
| Controller | Transacoes.php | Comunicação o banco de dados |
| Helper | pagamento_helper.php | Conversão de valores para o cliente |
| Model | TransacoesModel.php | Operações no banco de dados |

## Funcionamento:
Testes realizados em sandbox com geração de nome e CPF inválidos somentes para testes. 

### Listagem de todas transações:

![Listagem](https://user-images.githubusercontent.com/45601574/70070541-8e200500-15d2-11ea-979e-df7d617aedea.png)

### Pagamento cartão:

![Pagamento-cartao](https://user-images.githubusercontent.com/45601574/70101423-90568380-1613-11ea-9f03-adfea52c4329.gif)

### Pagamento boleto:

![Pagamento](https://user-images.githubusercontent.com/45601574/70101422-90568380-1613-11ea-9bb8-da7de6576753.gif)


<br>

## Utilização:

1. Seguir a instalação do PHP. Caso dê algum erro de instalação do CI4 com o PHP, siga estes passos [Instalação PHP](https://github.com/matheuscastroweb/ci4-crud/blob/master/README.md "Instalação PHP").

```php
#-----------------------------
# Extensões necessárias do php.ini
#-----------------------------
extension=mbstring
extension=mysqli
extension=curl
```

2.  Criar uma conta no [PagSeguro Sandbox](https://sandbox.pagseguro.uol.com.br/ "PagSeguro Sandbox"). A documentação pode ser acessar através do link [Documentação PagSeguro](https://dev.pagseguro.uol.com.br/docs "Documentação PagSeguro"). Ao alterar o `api.mode ` para `production` acessará a URL de produção do PagSeguro.


```php
#-----------------------------
# API PagSeguro - Alterar no .env
#-----------------------------
api.mode	= development
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

4. Para utilizar o módulo de notificação em localhost, basta acessar o PagSeguro e simular uma troca de status.

OBS. Sempre ao atualizar algum parâmetro do .env reinicie o servidor php.



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
    url_boleto VARCHAR(255),
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME DEFAULT NULL 
    );
```

