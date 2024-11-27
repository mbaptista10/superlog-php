# Superlog PHP

Superlog PHP é um projeto desenvolvido em PHP com foco em logs em linha no formato JSON. Este projeto utiliza Docker para configuração de ambiente, Composer para gerenciamento de dependências e ferramentas como PHPUnit, PHPStan, Laravel Pint e PestPHP para qualidade de código e testes.

## Índice

- [Requisitos](#requisitos)
- [Começando](#Começando)
- [Local](#local)

---

## Requisitos

- PHP 8.3 ou superior
- Docker e Docker Compose
- Make (opcional, para automação de tarefas)

---

## Começando

Comece instalando via composer:
   ```bash
   composer require mbaptista10/superlog-php 
   ```

Após isso, você deve configurar seu Superlog através da classe `Superlog\SuperlogSettings`. O ideal é que essa configuração seja feita no bootstrap do seu projeto.
Por padrão, o Superlog utiliza o canal `php://stdout` para escrever os logs, e usa o nível `debug` para exibir os logs. Você pode alterar esses valores através da classe `Superlog\SuperlogSettings`.
```php
<?php

declare(strict_types=1);

use Superlog\SuperlogSettings;

require __DIR__.'/vendor/autoload.php';

SuperlogSettings::setLogLevel('warning');
/**
 * Channel são todos os tipos aceitos pelo `Monolog\Handler\StreamHandler`. Por exemplo:
 * php://stdout, php://stderr, php://php://memory, file:///path/to/file.log, etc.
 **/
SuperlogSettings::setChannel('php://stdout');
SuperlogSettings::setApplication('app');
SuperlogSettings::setEnvironment('production');
```

### RFC
A ideia desta lib é usarmos o formato JSON para os logs, sendo assim foi estabelecido esse padrão de JSON para os logs:
- Campos que compõem:
  - timestamp: UTC (YYYY-MM-DDTHH:MM:SSZ)
  - level: critical / error / warning / info / debug
  - channel: php://stdout
  - environment: local / testing / staging / production / sandbox
  - application: (my-app)
  - message: string | json string
  - log_id: string (uuid-v4)
  - tags: ['log_id:{uuid-v4}', 'tag1', 'tag2']

### Levels
O Superlog suporta os níveis `debug`, `info`, `warning`, `error` e `critical`. Você pode alterar o nível através da classe `Superlog\SuperlogSettings`. Se o nível setado for `error` apenas os levels `error`, `critical` serão exibidos, se for `warning` apenas os levels `warning`, `error` e `critical` serão exibidos e assim por diante.

### Observer
Nós temos a interface `Superlog\Contracts\LoggerObserverContract` para você implementar seus próprios observers. Após isso, você pode registra-los através da classe `Superlog\SuperlogSettings` com o método `addObserver`. Os observers irão conter os métodos `logging` e `logged`.


## Local
Caso deseje rodar o projeto localmente, siga os passos abaixo:

1. Clone o repositório:
   ```bash
   git clone https://github.com/seu-usuario/superlog-php.git
   cd superlog-php
   ```

2. Instale as dependências:
   ```bash
   make install-deps
   ```

3. Construa as imagens:
   ```bash
   make build
   ```

4. Inicie os serviços:
   ```bash
   make up
   ```

5. Acesse o container do Superlog:
   ```bash
   make ssh
   ```

Se preferir pular esses passos, você pode simplesmente executar:
    ```bash
    make rebuild
    ```

Isso irá executar os passos 1-4 automaticamente.
