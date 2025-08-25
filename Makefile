CURRENT_UID := $(shell id -u)
CURRENT_GID := $(shell id -g)

.PHONY: build up down shell node-shell

build:
	docker compose build --build-arg USER_UID=$(CURRENT_UID) --build-arg USER_GID=$(CURRENT_GID)

up:
	docker compose up -d

down:
	docker compose down

shell:
	docker compose exec app bash

node-shell:
	docker compose exec node sh
