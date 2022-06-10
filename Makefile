.PHONY: start stop rm shell vendor

dc_bin := $(shell command -v docker-compose 2> /dev/null)
dc_app_name = fpm

DOCKER_COMPOSE=$(dc_bin)
PHP=php

start:
	${DOCKER_COMPOSE} up -d

stop:
	$(DOCKER_COMPOSE) stop

rm:
	$(DOCKER_COMPOSE) down

shell:
	$(DOCKER_COMPOSE) exec $(dc_app_name) bash

vendor:
	$(DOCKER_COMPOSE) exec $(dc_app_name) composer install