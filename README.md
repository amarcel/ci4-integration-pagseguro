# CodeIgniter 4  Integration PagSeguro API
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/5e86f42e3060402d96d20804335b3681)](https://www.codacy.com/manual/matheuscastroweb/ci4-integration-pagseguro?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=matheuscastroweb/ci4-integration-pagseguro&amp;utm_campaign=Badge_Grade) [![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=matheuscastroweb_ci4-integration-pagseguro&metric=alert_status)](https://sonarcloud.io/dashboard?id=matheuscastroweb_ci4-integration-pagseguro)

### Under development. Last tested version [here](https://github.com/matheuscastroweb/ci4-integration-pagseguro/tree/master "aqui)").

## Content:

- [Features](#features "Features")
- [Structure library](#structure-library "Structure library")
- [Error table](#error-table "Error table")
- [Operation](#operation "Operation")
- [Latest stable version](https://github.com/matheuscastroweb/ci4-integration-pagseguro/tree/master "Latest stable version") 


## Installation:

See the archive [INSTALLING.md](INSTALLING.md).

## Contribution:

See the archive [CONTRIBUTING.md](CONTRIBUTING.md).

## Updates:

See the archive [CHANGELOG.md](CHANGELOG.md).

## Features:

- Billet generation by API
- Payment by credit card
- Callback when updating any payment status
- Validation with a unique reference code
- Sending email confirmation of order status
- Boleto in Lightbox in a modal
- Loader to wait for payment request
- Logs for each transaction status

## Structure library:
| Function | Reason |
| ------ | ------ |
| `getSession` | Generate a mandatory payment session | 
| `requestNotification` | Receive PagSeguro notification of status change |
| `paymentBillet` | Generate payment by bank slip |
| `paymentCard` | Generate payment by credit card | 
| `_store` | Adds a transaction to the database | 
| `_edit` | Edit a transaction status in the database |
| `_notifyStatus` | Sends email notification about order status | 
| `_getChamada` | Make the cURL call to the PagSeguro server | 

- In the `/ Demo` folder contains the version already installed on Codeigniter 4.

- Instructions for use:  

```php
use App\Libraries\PagSeguro;

$pagseguro = new PagSeguro();

//Puxar a function necessária
$pagseguro->function();
```

- It is necessary to create an account on [PagSeguro Sandbox](https://sandbox.pagseguro.uol.com.br/ "PagSeguro Sandbox"). The documentation can be accessed through the link [Documentation PagSeguro](https://dev.pagseguro.uol.com.br/docs "Documentation PagSeguro"). Change `Config/PagSeguro.php` to access the production URL of PagSeguro when the project is finished.

- Change the test email provided in PagSeguro `. / Views / home` in the` email` field to use in PagSeguro development mode and make payments.

- To use the notification module at localhost, simply access PagSeguro and simulate a status change.

## Error table:
| Code | Description |
| ------ | ------ |
| 1000 | Error generating payment session |
| 1001 | Incorrect parameters in Pagseguro configuration |
| 1002 | Error receiving notification code |
| 1003 | There is no transaction code |
| 1004 | Error when registering transaction in the boleto type database |
| 1005 | Error generating billet type transaction |
| 1006 | Error when registering card type transaction |
| 1007 | Error generating card type transaction |
| 1008 | Error when calling the server |


## Operation:
Tests performed in sandbox with name generation and invalid CPF only for testing.

### List of all transactions:

![List](https://user-images.githubusercontent.com/45601574/70375547-a4350a80-18dd-11ea-8999-5a4b33df7d44.png)

### Card payment:

![Card-payment](https://user-images.githubusercontent.com/45601574/70101423-90568380-1613-11ea-9f03-adfea52c4329.gif)

### Payment slip:

![Payment-slip](https://user-images.githubusercontent.com/45601574/70101422-90568380-1613-11ea-9bb8-da7de6576753.gif)

