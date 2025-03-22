<p align="center">
    <a href="https://github.com/mbaptista10/superlog-php/actions"><img alt="GitHub Workflow Status (main)" src="https://github.com/mbaptista10/superlog-php/actions/workflows/tests.yml/badge.svg"></a>
    <a href="https://packagist.org/packages/mbaptista/superlog-php"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/mbaptista10/superlog-php"></a>
    <a href="https://packagist.org/packages/mbaptista10/superlog-php"><img alt="Latest Version" src="https://img.shields.io/packagist/v/mbaptista10/superlog-php"></a>
    <a href="https://packagist.org/packages/mbaptista10/superlog-php"><img alt="License" src="https://img.shields.io/packagist/l/mbaptista10/superlog-php"></a>
</p>

---

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
Por padrão, o Superlog ira transmitir os logs para `php://stdout`, e usa o nível `debug` como padrão para exibir os logs. Você pode alterar esses valores através da classe `Superlog\SuperlogSettings`.
```php
<?php

declare(strict_types=1);

use Superlog\SuperlogSettings;

require __DIR__.'/vendor/autoload.php';

SuperlogSettings::setLogLevel('warning');
SuperlogSettings::setApplication('app');
SuperlogSettings::setEnvironment('production');
```

### RFC
A ideia desta lib é usarmos o formato JSON para os logs, sendo assim foi estabelecido esse padrão de JSON para os logs:
- Campos que compõem:
  - version: v2
  - timestamp: UTC (YYYY-MM-DDTHH:MM:SSZ)
  - level: alert / critical / error / warning / info / debug
  - environment: local / testing / staging / production / sandbox
  - application: (my-app)
  - trace_id: string
  - span_id: string
  - message: string | json string
  - tags: json (key-value) {"foo":"bar", "baz":"qux", "log_id":"uuid-v4"}

### Levels
O Superlog suporta os níveis `debug`, `info`, `warning`, `error` , `critical` e `alert`. Você pode alterar o nível através da classe `Superlog\SuperlogSettings`. Se o nível setado for `error` apenas os levels `error`, `critical` e `alert` serão exibidos, se for `warning` apenas os levels `warning`, `error` , `critical` e `alert` serão exibidos e assim por diante.

### Observers
Nós temos a interface `Superlog\Contracts\LoggerObserverContract` para você implementar seus próprios observers. Após isso, você pode registra-los através da classe `Superlog\SuperlogSettings` com o método `addObserver`. Os observers irão conter os métodos `logging` e `logged`. Você pode definir quantos observadores desejar, e cada um deles será notificado quando um log for registrado.

O Superlog oferece uma integração com o Datadog para rastreamento e observabilidade através dos observers. Para utilizar esse recurso, você precisa instalar o agent do Datadog [dd-trace-php](https://github.com/DataDog/dd-trace-php) e configurar o Superlog para utilizá-las. Para isso, basta chamar o método `useDatadogTracerObserver` no bootstrap do seu projeto. Isso irá adicionar os campos `trace_id` e `span_id` aos logs. Na prática esse método irá adicionar um observador `DatadogTracerObserver` que irá adicionar esses campos aos logs.
```php
<?php

declare(strict_types=1);

use Superlog\SuperlogSettings;

require __DIR__.'/vendor/autoload.php';

SuperlogSettings::useDatadogTracerObserver();
```

Também é possível utilizar o método `useCustomTracerObserver` para adicionar os campos `trace_id` e `span_id` aos logs. Esse método irá adicionar 'uuid-v4' como valores para esses campos. Na prática esse método irá adicionar um observador `CustomTracerObserver` que irá adicionar esses campos aos logs.
```php
<?php

declare(strict_types=1);

use Superlog\SuperlogSettings;

require __DIR__.'/vendor/autoload.php';

SuperlogSettings::useCustomTracerObserver();
```

### Desabilitar o Superlog
Se você deseja desabilitar o Superlog, você pode fazer isso através da classe `Superlog\SuperlogSettings`. Para isso, basta chamar o método `disableWhen` com o valor `true`.
```php
<?php

declare(strict_types=1);

use Superlog\SuperlogSettings;

require __DIR__.'/vendor/autoload.php';

SuperlogSettings::disableWhen(APP_ENV === 'testing');
```


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
