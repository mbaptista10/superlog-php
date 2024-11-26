ARG BASE_IMAGE
FROM ${BASE_IMAGE} as base
USER root

FROM base as dev

RUN install-php-extensions xdebug

# Carrega arquivos de configurações do PHP
COPY ./docker/conf.d/ "${PHP_INI_DIR}/conf.d/"

# Carrega os arquivos da aplicação
COPY --chown=www-data:www-data . /var/www/html


CMD ${DEPLOY_CMD}
