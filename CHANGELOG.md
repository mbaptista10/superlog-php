# Changelog

Todas as alterações relevantes para este projeto serão documentadas neste arquivo.

O formato segue o padrão [Keep a Changelog](http://keepachangelog.com/) e este projeto adere a [Versionamento Semântico](http://semver.org/).

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
