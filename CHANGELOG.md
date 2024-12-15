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
