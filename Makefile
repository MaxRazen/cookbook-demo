.PHONY: help up down docker-env
.SILENT: help up down docker-env
.DEFAULT_GOAL: help

## Variables
dc_bin := $(shell command -v docker-compose 2> /dev/null)
CONFIG_ARGS=-f ./docker-environment/docker-compose.yml --env-file ./docker-environment/.env

## Commands
help: ## Show help
	@printf "\033[33m%s:\033[0m\n" 'Available commands'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[32m%-18s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

up: ## Start containers
	$(dc_bin) ${CONFIG_ARGS} up -d mysql workspace php-fpm nginx zookeeper kafka

down: ## Down containers
	docker stop $$(docker ps --filter "name=cookbook_*" -q)

bash: ## Login into application container
	$(dc_bin) ${CONFIG_ARGS} exec --user=luke workspace bash | tee /dev/null

docker-env: ## Copy .env and prepare for build
	cp ./docker-environment/.env.example ./docker-environment/.env
	cp ./docker-environment/nginx/sites/local-cookbook.conf.example ./docker-environment/nginx/sites/local-cookbook.conf
