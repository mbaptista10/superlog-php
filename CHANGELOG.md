# Changelog
Todas as alterações relevantes para este projeto serão documentadas neste arquivo.

O formato segue o padrão [Keep a Changelog](http://keepachangelog.com/)
e este projeto adere a [Versionamento Semântico](http://semver.org/).

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

