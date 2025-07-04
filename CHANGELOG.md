# Changelog

Todas as alterações relevantes para este projeto serão documentadas neste arquivo.

O formato segue o padrão [Keep a Changelog](http://keepachangelog.com/) e este projeto adere a [Versionamento Semântico](http://semver.org/).

## [1.7.0] - 2025-06-23
### Adicionado
- **Suporte ao PHP 8.2**:
  - Adicionado suporte oficial para execução do projeto em ambientes com PHP 8.2. (#3805e4d)

---

## [1.6.0] - 2025-03-22
### Adicionado
- **Suporte a rastreamento e observadores**:
  - Implementados os observadores `CustomTracerObserver` e `DatadogTracerObserver`.
  - Adicionados os campos `trace_id` e `span_id` no formato de log.
  - Adicionados os métodos `useCustomTracerObserver` e `useDatadogTracerObserver`.
  - Atualizado o `Dockerfile` para instalar dependências do Datadog.
  - Criado o stub `ddtrace.stub.php` para auxiliar no CI/CD.
  - Atualizados os testes para cobrir os novos recursos de rastreamento. (#cee7830)

- **Novo nível de log: `alert`**:
  - Adicionado o método `alert()` à interface `LoggerContract`.
  - Implementado suporte ao nível `alert` na classe `Superlog`.
  - Atualizado `SuperlogSettings` para reconhecer o nível `alert`.
  - Adicionados testes para validar o novo nível de log. (#5d6ba54)

### Alterado
- **Encapsulamento no `SuperlogData`**:
  - Propriedades tornadas privadas e somente leitura.
  - Criados métodos de acesso `level()` e `message()`.
  - Atualizado o uso dessas propriedades no `Superlog` e nos testes. (#ffc0169)

- **Melhorias no gerenciamento de níveis de log e streams**:
  - Suporte adicionado para logs em `stderr`.
  - Validação centralizada dos níveis de log.
  - Lógica de seleção de stream refatorada com base no nível.
  - Maior consistência no tratamento de níveis de log. (#19113c9)

- **Refatoração nos scripts de CI e linting**:
  - Separação dos comandos de linting: `Rector`, `Pint`, `PHPStan`.
  - Renomeação de scripts no `composer.json` para maior clareza.
  - Atualização dos workflows do GitHub Actions.
  - Adicionado script `checks` para rodar todas as validações. (#55d53ac)

### Removido
- **Campo `channel` dos logs**:
  - Campo `channel` e suas referências removidas por simplicidade.
  - Atualização da documentação e remoção dos testes relacionados. (#06cf7a1)

---

## [1.5.0] - 2025-01-03
### Adicionado
- **Opção para desabilitar o logger**:
  - Implementado o método `disableWhen` na classe `SuperlogSettings` para desativar o logger condicionalmente.
  - Adicionada verificação `isDisabled` em todos os métodos de logging para garantir que logs não sejam gerados quando o logger estiver desabilitado.
  - Incluídos testes para validar o comportamento do logger desabilitado. (#0a87e3e)

---

## [1.4.0] - 2024-12-15
### Adicionado
- **Suporte para logging em stdout e streams personalizados**:
  - Modificada a classe `SuperlogSettings` para aceitar `stdout` ou uma string como stream.
  - Atualizada a lógica de `getStream` para lidar com streams personalizados e `stdout`.
  - Adicionados testes cobrindo cenários de logging em `stdout` e recursos personalizados.
  - Atualizado o `.gitignore` para incluir arquivos relacionados a streams. (#e6e6455)

---

## [1.3.0] - 2024-12-13
### Adicionado
- **Cobertura de código no workflow de testes**:
  - Adicionada configuração do Xdebug para incluir cobertura de código no workflow do GitHub Actions. (#745b049)
- **Configuração de arquitetura para testes**:
  - Adicionado o arquivo `Arch.php` com presets de PHP e verificações de segurança. (#f0e8ecf)
  
### Alterado
- **Estrutura de tags e timestamps**:
  - Alterada a estrutura de tags para usar chave-valor.
  - Modificado o formato de timestamp para RFC3339 em UTC. (#e1ef9a6)
- **Renomeação e otimização de workflows no GitHub Actions**:
  - Renomeados arquivos de configuração para linting.
  - Restrição dos fluxos de trabalho para execução apenas em pull requests.
  - Ajustes para uso de comandos do Composer nos testes. (#7f3be47)

### Corrigido
- **Codificação de mensagens como JSON no SuperlogData**:
  - Atualização no método `toArray()` para codificar mensagens como JSON.
  - Ajustes nos testes para refletir a nova estrutura de mensagens. (#fe1cc76)

### Removido
- **Campo `log_id` do objeto JSON de saída**:
  - Campo removido para simplificar a estrutura de logs. O valor agora está presente nas tags. (#b7d759f)

---

## [1.2.0] - 2024-12-09
### Adicionado
- **Método `raw` para logging dinâmico**:
  - Adicionado o método `raw` à interface `LoggerContract` e implementado na classe `Superlog`.
  - Permite registrar logs com níveis especificados dinamicamente, oferecendo maior flexibilidade.
  - Testes incluídos para garantir a funcionalidade do método. (#f583480)

---

## [1.1.0] - 2024-12-06
### Adicionado
- **Funcionalidade de anexar mensagens ao SuperlogData**:
  - A classe `SuperlogData` agora permite anexar mensagens com o método público `appendToMessage`.
  - Adicionado o método privado `formatMessage` para formatar mensagens.
  - A propriedade `message` foi modificada para ser um array.
  - Atualizações no construtor para usar o novo formato de mensagens.
  - Ajustes em testes para refletir as mudanças. (#9d4f75b)

### Alterado
- A classe `SuperlogData` deixou de ser `readonly` para suportar modificações em mensagens.

---

## [1.0.1] - 2024-11-27
### Adicionado
- **Badges no README**:
  - Status do workflow do GitHub.
  - Total de downloads.
  - Versão mais recente.
  - Licença.
- Melhorias visuais no README com separação por linha horizontal.

- **Licença MIT**:
  - Adicionado o arquivo `LICENSE.md` com os termos da licença MIT.

---

## [1.0.0] - 2024-11-27
### Adicionado
- Implementado sistema de logging com:
  - `LoggerContract` para definir métodos de logging.
  - `SuperlogData` para estruturar dados de log.
  - `Superlog` para lógica de logging.
  - `SuperlogSettings` para configurações.
  - `LoggerObserverContract` para definir métodos de observação do logger.
  - Testes para validar o funcionamento do sistema. (#66a0abcd)
- Configuração do Xdebug no Docker para executar localmente o projeto:
  - Arquivos de configuração do PHP.
  - Arquivo `991-xdebug.ini`.
  - Configurações para desenvolvimento, cobertura, depuração e perfil. (#e8c36bb7)
- Adicionada dependência `ramsey/uuid` na versão `^4.7`. (#795c01e3)
- Adicionada dependência `monolog/monolog` na versão `^3.7`. (#0f07212d)
