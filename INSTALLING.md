
# Using Library PagSeguro:

- If you want to use the Demo, just use `cd Demo` and` php spark serve` assuming that this installation of PHP is already complete. Otherwise, go to: [PHP installation] (https://github.com/matheuscastroweb/ci4-crud/blob/master/README.md "PHP installation").
1. Download the repository:

`git clone https://github.com/matheuscastroweb/ci4-integration-pagseguro.git`

2. Copy folders from the repository into your project as follows:

| Folder | Destiny |
| ------ | ------ | 
| Config |  `app/` | 
| Controllers |  `app/` |
| Helpers | `app/` |
| Libraries |  `app/` | 
| Migrations |  `app/` | 
| Models |  `app/` |
| Views |  `app/` | 
| public | `/` | 

> **OBS.:** Will ask you to replace the files, just confirm.

3. Create database


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
Or use migration
```php
#Rodar a migration
php spark migrate

```


4.  Configure database within the framework

```php
#Location - app/Config/Database

	public $default = [
        {...}
            'hostname' => 'localhost',
            'username' => 'root',
            'password' => '',
	    'database' => 'ci4_integration_pagseguro',
	{...}
	];
```

5.  Configure PagSeguro variables

```php
#Location - app/Config/PagSeguro

    /**
    * E-mail para configuração do PagSeguro
    * @var String
    */
    public $email;

    /**
    * Token para configuração do PagSeguro
    * @var String
    */
    public $token;

```

6.  Configure Email:

- Serviço de e-mail utilizado [Mailtrap](https://mailtrap.io/ "Mailtrap").

```php
#Location - app/Config/Email

   /**
     * Using e-mail
     * Alterar para TRUE se deseja utilizar os avisos por e-mail
     * @var bool
     */
    public $usingEmail = false; 

    /**
     * SMTP Server Address
     *
     * @var string
     */
    public $SMTPHost = 'seuHOST';
    /**
     * SMTP Username
     *
     * @var string
     */
    public $SMTPUser = 'seuUSER';
    /**
     * SMTP Password
     *
     * @var string
     */
    public $SMTPPass = 'suaSENHA';

```

7.  Change Logger to view transaction logs

```php
#Location - app/Config/Logger

#After
public $threshold = 3;

#Before
public $threshold = array(1, 2, 3, 7);

```

8. Run the project and access the `/listagem`

`php spark serve`

```php
#-----------------------------
# Extensões necessárias do php.ini
#-----------------------------
extension=mbstring
extension=mysqli
extension=curl
extension=openssl
```



> **OBS.:** If base_url is not localhost:8080, configure this document to generate the sessions `assets/js/sessao.js `

