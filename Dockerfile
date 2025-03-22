ARG BASE_IMAGE
FROM ${BASE_IMAGE} as base
USER root

RUN apk --no-cache add \
    libgcc \
    libpng \
    libpng-dev \
    libjpeg-turbo \
    libjpeg-turbo-dev \
    freetype \
    freetype-dev \
    procps \
    coreutils \
    util-linux

RUN cd /tmp/ \
    && curl -LO "https://github.com/DataDog/dd-trace-php/releases/download/0.99.1/datadog-setup.php" \
    && php datadog-setup.php --php-bin=all --enable-appsec

FROM base as dev

RUN install-php-extensions xdebug

# Carrega arquivos de configurações do PHP
COPY ./docker/conf.d/ "${PHP_INI_DIR}/conf.d/"

# Carrega os arquivos da aplicação
COPY --chown=www-data:www-data . /var/www/html


CMD ${DEPLOY_CMD}
