#!/bin/sh

# Define o diretório de trabalho de trabalho
WORKDIR="$(pwd)"

# Verifica se o diretório "vendor" existe no diretório de trabalho
if [ ! -d "$WORKDIR/vendor" ]; then
  echo "Diretório 'vendor' não encontrado em $WORKDIR. Instalando dependências..."

  docker run --rm \
    --pull=always \
    -v "$WORKDIR":/var/www/html \
    -w /var/www/html \
    --user root \
    serversideup/php:8.3-cli-alpine \
    ash -c "composer install"
else
  echo "Diretório 'vendor' já existe em $WORKDIR. Dependências já instaladas."
fi
