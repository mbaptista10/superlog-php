#!/usr/bin/make -f
.SILENT:
.PHONY: help build up uplog down ssh clean freespace

## Colors
COLOR_RESET   = \033[0m
COLOR_INFO  = \033[32m
COLOR_COMMENT = \033[33m

## Exibe as instruções de uso
help:
	printf "${COLOR_COMMENT}Uso:${COLOR_RESET}\n"
	printf " make [comando]\n\n"
	printf "${COLOR_COMMENT}Comandos disponíveis:${COLOR_RESET}\n"
	awk '/^[a-zA-Z\-\_0-9\.@]+:/ { \
		helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			printf " ${COLOR_INFO}%-16s${COLOR_RESET} %s\n", helpCommand, helpMessage; \
		} \
	} \
	{ lastLine = $$0 }' $(MAKEFILE_LIST)

## Constroi as imagens
build:
	make install-deps
	@echo 🐳🛠️ Construindo as imagens
	docker-compose build --no-cache
	@echo 🐳✅ Comando "build" finalizado

## Destroi as imagens
down:
	@echo 🐳⬇️ Destruindo as imagens
	docker-compose down --remove-orphans
	@echo 🐳✅ Comando "down" finalizado

rebuild:
	@echo 🐳🛠️ Reconstruindo as imagens
	make down
	make build
	docker-compose up -d --force-recreate
	@echo 🐳✅ Comando "rebuild" finalizado

## Inicia todos os serviços
up:
	@echo 🐳⬆️ Iniciando os serviços
	docker-compose up -d
	@echo 🐳✅ Comando "up" finalizado

## Para os serviços
stop:
	@echo 🐳⏹️ Parando os serviços
	docker-compose stop
	@echo 🐳✅ Comando "stop" finalizado

## Reinicia os serviços
restart:
	@echo 🐳🔃 Reiniciando os serviços
	docker-compose restart
	@echo 🐳✅ Comando "restart" finalizado

## Instala as dependências do projeto
install-deps:
	@echo 🔍 Instalando as dependências
	./bin/install-deps-php.sh
	@echo ✅ Comando "install-deps" finalizado

## Acessa o container do Superlog
ssh:
	@echo 🐳🖥️ Acessando o container do Superlog
	docker-compose exec superlog-php ash
	@echo 🐳✅ Comando "ssh" finalizado
