# CodeIgniter 4  Integration PagSeguro API
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/5e86f42e3060402d96d20804335b3681)](https://www.codacy.com/manual/matheuscastroweb/ci4-integration-pagseguro?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=matheuscastroweb/ci4-integration-pagseguro&amp;utm_campaign=Badge_Grade) [![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=matheuscastroweb_ci4-integration-pagseguro&metric=alert_status)](https://sonarcloud.io/dashboard?id=matheuscastroweb_ci4-integration-pagseguro)

### Em desenvolvimento. Última versão testada [ aqui ](https://github.com/matheuscastroweb/ci4-integration-pagseguro/tree/master "aqui)").

## Conteúdo:

- [Features](#features "Features")
- [Estrutura library](#estrutura-library "Estrutura library")
- [Tabela de erros](#tabela-de-erros "Tabela de erros")
- [Funcionamento](#funcionamento "Funcionamento")
- [Última versão estável](https://github.com/matheuscastroweb/ci4-integration-pagseguro/tree/master "Última versão estável") 


## Instalação:

Veja o arquivo [INSTALLING.md](INSTALLING.md).

## Contribuição:

Veja o arquivo [CONTRIBUTING.md](CONTRIBUTING.md).

## Atualizações:

Veja o arquivo [CHANGELOG.md](CHANGELOG.md).

## Features:

- Geração de boleto pela API
- Pagamento por cartão de crédito
- Callback ao atualizar algum status de pagamento
- Validação com um código de referência unico
- Envio de confirmação por e-mail do status do pedido
- Boleto em Lightbox em um modal
- Loader para aguardar requisição de pagamento
- Logs a cada status da transação


## Estrutura library:
| Função | Razão |
| ------ | ------ |
| `getSession` | Gerar uma sessão de pagamento obrigatória| 
| `requestNotification` | Receber notificação do PagSeguro de alteração de status |
| `paymentBillet` | Gerar pagamento por boleto bancário |
| `paymentCard` | Gerar pagamento por cartão de crédito | 
| `_store` | Adicionar uma transação ao banco de dados | 
| `_edit` | Editar um status de transação no banco de dados |
| `_notifyStatus` | Envia notificação por e-mail sobre o status do pedido | 
| `_getChamada` | Realizar a chamada cURL ao servidor do PagSeguro | 

- Na pasta `/Demo` contém a versão já instalada no Codeigniter 4.  

- Forma de utilização:  

```php
use App\Libraries\PagSeguro;

$pagseguro = new PagSeguro();

//Puxar a function necessária
$pagseguro->function();
```

-  É necessário criar uma conta no [PagSeguro Sandbox](https://sandbox.pagseguro.uol.com.br/ "PagSeguro Sandbox"). A documentação pode ser acessar através do link [Documentação PagSeguro](https://dev.pagseguro.uol.com.br/docs "Documentação PagSeguro"). Altere `Config/PagSeguro.php` para acessar a URL de produção do PagSeguro quando finalizado o projeto.

-  Alterar o email de teste disponibizado no PagSeguro `./Views/home` no campo `email` para utilizar em modo desenvolvimento do PagSeguro e fazer os pagamentos. 

- Para utilizar o módulo de notificação em localhost, basta acessar o PagSeguro e simular uma troca de status.

## Tabela de erros:
| Código | Descrição |
| ------ | ------ |
| 1000 | Erro ao gerar sessão de pagamento | 
| 1001 | Parâmetros incorretos na configuração do Pagseguro |
| 1002 | Erro ao receber código de notificação |
| 1003 | Não existe código de transação |
| 1004 | Erro ao cadastrar transação no banco de dados do tipo boleto|
| 1005 | Erro ao gerar transação do tipo boleto |
| 1006 | Erro ao cadastrar transação do tipo cartão |
| 1007 | Erro ao gerar transação do tipo cartão |
| 1008 | Erro ao realizar chamada ao servidor |


## Funcionamento:
Testes realizados em sandbox com geração de nome e CPF inválidos somentes para testes. 

### Listagem de todas transações:

![Listagem](https://user-images.githubusercontent.com/45601574/70375547-a4350a80-18dd-11ea-8999-5a4b33df7d44.png)

### Pagamento cartão:

![Pagamento-cartao](https://user-images.githubusercontent.com/45601574/70101423-90568380-1613-11ea-9f03-adfea52c4329.gif)

### Pagamento boleto:

![Pagamento](https://user-images.githubusercontent.com/45601574/70101422-90568380-1613-11ea-9bb8-da7de6576753.gif)

