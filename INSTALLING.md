
# Utilização Library PagSeguro:

- Caso queira utilizar a Demo, basta utilizar `cd Demo` e `php spark serve` assumindo que esta instalação do PHP já está completa. Do contrário, acesse: [Instalação PHP](https://github.com/matheuscastroweb/ci4-crud/blob/master/README.md "Instalação PHP").

1. Realizar o dowload do repositório:

`git clone https://github.com/matheuscastroweb/ci4-integration-pagseguro.git`

2. Copias pastas do repositório para dentro do seu projeto conforme abaixo:

| Pasta | Destino |
| ------ | ------ | 
| Config |  `app/` | 
| Controllers |  `app/` |
| Helpers | `app/` |
| Libraries |  `app/` | 
| Migrations |  `app/` | 
| Models |  `app/` |
| Views |  `app/` | 
| public | `/` | 

> **OBS.:** Irá solicitar que substitua os arquivos, basta confirmar.

3. Criar banco de dados


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
Ou utilizar a migration
```php
#Rodar a migration
php spark migrate

```


4.  Configurar banco de dados dentro do framework

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

5.  Configurar variáveis do PagSeguro

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

6.  Configurar E-mail:

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

7.  Altera Logger para visualizar os logs de transações

```php
#Location - app/Config/Logger

#After
public $threshold = 3;

#Before
public $threshold = array(1, 2, 3, 7);

```

8. Rodar o projeto e acessar o `/listagem`

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



> **OBS.:** Caso a base_url não seja localhost:8080, configurar neste documentos para gerar as sessões `assets/js/sessao.js `

