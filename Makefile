.PHONY: all
UID=$(shell id -u)
GID=$(shell id -g)

XDEBUG_HOST=$(shell docker network inspect bridge --format='{{(index .IPAM.Config 0).Gateway}}')

DOCKER_COMPOSE=XDEBUG_HOST=$(XDEBUG_HOST) UID=${UID} GID=${GID} docker-compose
PHP_STAN_COMMAND=php -d memory_limit=512M vendor/bin/phpstan -n --level=8 analyze -c phpstan.neon
PHP_CODE_SNIFFER=php -d memory_limit=512M vendor/bin/phpcs -s --standard=PSR12 -n
DOCKER_PHP_CLI=docker run --rm -i -u ${UID}:${GID} -v ${PWD}:/app -w /app php:8-cli
PHP_COMPOSER=docker run --rm -i -t -u ${UID}:${GID} -v ${PWD}/app:/app -w /app composer:latest composer


all: help

help: ## Lista los comandos disponibles
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

build: ## Construye la imagen del proyecto
	$(DOCKER_COMPOSE) build

up: ## Inicia la imagen del proyecto
	$(DOCKER_COMPOSE) up -d hlc phpmyadmin

down: ## Detiene la imagen del proyecto
	$(DOCKER_COMPOSE) down --rmi all

php-stan: app/src app/test ## Ejecuta el analizador de código php stan en el proyecto
	$(DOCKER_PHP_CLI) $(PHP_STAN_COMMAND) app/src
	$(DOCKER_PHP_CLI) $(PHP_STAN_COMMAND) app/test

php-ld: ## Ejecuta el analizador de código de php básico en el proyecto
	$(DOCKER_PHP_CLI) php -l -d display_errors=0 $(args)

php-code-sniffer: ## Ejecuta el analizador de código code sniffer en el proyecto
	$(DOCKER_PHP_CLI) $(PHP_CODE_SNIFFER) -p $(args)

composer: ## Ejecuta composer para instalar las denpendencias del proyecto
	$(PHP_COMPOSER) install

composer-require: ## Ejecuta composer para instalar una libreria Ejemplo: make copmposer-require lib=catfan/medoo
	$(PHP_COMPOSER) require $(lib)

composer-update: ## Ejecuta composer para actualizar las librerías del proyecto
	$(PHP_COMPOSER) update

