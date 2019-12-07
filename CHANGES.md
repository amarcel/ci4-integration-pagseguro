## [v0.0.5]
> Dez 07, 2019

- Adição do extension=openssl para funcionamento do envio de e-mail

## [v0.0.4]
> Dez 06, 2019

- Correção da versão [v0.0.3] para fazer a verificação apenas no Controller necessário.
- Alteração do pagamento helper para limpar código
- Realocação da session pagseguro para um novo controller
- Aperfeiçoando o layout
- Colocar do boleto na função de notificar por e-mail 
- Aguardar a requisição da Session para liberar o botão de pagamento

## [v0.0.3]
> Dez 05, 2019

- Alterado o envio de e-mail para realizar apenas quando a variável de ambiente for `true`

## [v0.0.2]
> Dez 04, 2019

- Adição da página Status antes de inicar o código para que possa ser realizado as verificações do pagseguro.
- Alterado `public $threshold = 9;` em `app/Config/Logger` para exibir todos os logs
- Adicionado log de transações
- Adicionado funcionalidade para utilizar ou não envio de e-mail `default: false`
- Resolvido problema #4 do envio de e-mail
- REMOVIDO :: Busca de transação por ID 
- Adicionado no routes `$routes->get('/(:num)', 'Home::list/$1');`

## [v0.0.1]
> Dez 03, 2019

- Finalização do método de pagamento por cartão
- Correção de bugs
- Adição do pre-loader de pagamento
- Melhoria de organização de código
