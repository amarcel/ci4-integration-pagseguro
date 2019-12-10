# CodeIgniter 4  Integration PagSeguro API
![](https://img.shields.io/github/issues-raw/matheuscastroweb/ci4-integration-pagseguro) ![](https://img.shields.io/github/contributors/matheuscastroweb/ci4-integration-pagseguro) ![](https://img.shields.io/github/stars/matheuscastroweb/ci4-integration-pagseguro) 

### Em desenvolvimento. Última versão testada [ aqui (master)](https://github.com/matheuscastroweb/ci4-integration-pagseguro/tree/master "aqui (master)").
## Conteúdo:

- [Features](#features "Features")
- [Estrutura library](#estrutura-library "Estrutura library")
- [Utilização](https://github.com/matheuscastroweb/ci4-integration-pagseguro/blob/develop/INSTALLING.md "Utilização")
- [Atualizações](https://github.com/matheuscastroweb/ci4-integration-pagseguro/blob/develop/CHANGELOG.md "Atualizações")
- [Funcionamento](#funcionamento "Funcionamento")
- [Contribuir](https://github.com/matheuscastroweb/ci4-integration-pagseguro/blob/develop/CONTRIBUTING.md "Contribuir")
- [Última versão estável](https://github.com/matheuscastroweb/ci4-integration-pagseguro/tree/master "Última versão estável") 

## Features:

- Geração de boleto pela API
- Pagamento por cartão de crédito
- Callback ao atualizar algum status de pagamento
- Validação com um código de referência unico
- Envio de confirmação por e-mail do status do pedido
- Boleto em Lightbox em um modal
- Loader para aguardar requisição de pagamento
- Logs a cada status da transação

## Estrutura da library:
| Função | Razão |
| ------ | ------ |
| getSession | Gerar uma sessão de pagamento obrigatória| 
| requestNotification | Receber notificação do PagSeguro de alteração de status |
| paymentBillet | Gerar pagamento por boleto bancário |
| paymentCard | Gerar pagamento por cartão de crédito | 
| store | Adicionar uma transação ao banco de dados | 
| edit | Editar um status de transação no banco de dados |
| notifyStatus | Envia notificação por e-mail sobre o status do pedido | 

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


## Funcionamento:
Testes realizados em sandbox com geração de nome e CPF inválidos somentes para testes. 

### Listagem de todas transações:

![Listagem](https://user-images.githubusercontent.com/45601574/70375547-a4350a80-18dd-11ea-8999-5a4b33df7d44.png)

### Pagamento cartão:

![Pagamento-cartao](https://user-images.githubusercontent.com/45601574/70101423-90568380-1613-11ea-9f03-adfea52c4329.gif)

### Pagamento boleto:

![Pagamento](https://user-images.githubusercontent.com/45601574/70101422-90568380-1613-11ea-9bb8-da7de6576753.gif)

