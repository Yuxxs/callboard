dir=${CURDIR}
export COMPOSE_PROJECT_NAME=callboard
ifndef APP_ENV
	# Determine if .env file exist
	ifneq ("$(wildcard .env)","")
		include .env
	endif
endif
interactive:=$(shell [ -t 0 ] && echo 1)
ifneq ($(interactive),1)
	optionT=-T
endif

project=-p ${COMPOSE_PROJECT_NAME}
service=${COMPOSE_PROJECT_NAME}:latest

deploy: build-no-cache env start composer-install key-generate config-cache

env:
	@make exec cmd="cp ./.env.example ./.env"

build:
	@docker-compose -f docker-compose.yml build

build-no-cache:
	@docker-compose -f docker-compose.yml build --no-cache

start:
	@docker-compose -f docker-compose.yml $(project) up -d

stop:
	@docker-compose -f docker-compose.yml $(project) down

restart: stop start

exec:
	@docker-compose $(project) exec $(optionT) app $$cmd

exec-bash:
	@docker-compose $(project) exec $(optionT) app bash -c "$(cmd)"

composer-install:
	@make exec-bash cmd="COMPOSER_MEMORY_LIMIT=-1 composer install --optimize-autoloader"

composer-update:
	@make exec-bash cmd="COMPOSER_MEMORY_LIMIT=-1 composer update"

dump-autoload:
	@make exec-bash cmd="COMPOSER_MEMORY_LIMIT=-1 composer dump-autoload"

key-generate:
	@make exec cmd="php artisan key:generate"

migrate:
	@make exec cmd="php artisan migrate --force"

drop-migrate:
	@make exec cmd="php artisan migrate:fresh"

migrate-fresh:
	@make exec cmd="php artisan migrate:fresh"

migrate-refresh:
	@make exec cmd="php artisan migrate:refresh"

seed:
	@make exec cmd="php artisan db:seed --force"
config-cache:
	@make exec cmd="php artisan config:cache"
