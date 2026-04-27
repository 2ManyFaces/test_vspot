.PHONY: help up down build rebuild logs php-shell db-shell migrate-fresh seed test

help:
	@echo "VibeSpot Docker Commands"
	@echo "========================"
	@echo "make up              - Start all containers"
	@echo "make down            - Stop all containers"
	@echo "make build           - Build all containers"
	@echo "make rebuild         - Rebuild all containers from scratch"
	@echo "make logs            - View logs from all containers"
	@echo "make logs-php        - View PHP logs"
	@echo "make logs-nginx      - View Nginx logs"
	@echo "make logs-frontend   - View Frontend logs"
	@echo "make php-shell       - Access PHP container shell"
	@echo "make db-shell        - Access PostgreSQL shell"
	@echo "make migrate         - Run database migrations"
	@echo "make migrate-fresh   - Fresh database migrations with seed"
	@echo "make seed            - Run database seeders"
	@echo "make test            - Run PHP unit tests"
	@echo "make tinker          - Access Laravel Tinker console"
	@echo "make install-deps    - Install PHP and Node dependencies"

up:
	docker-compose up -d

down:
	docker-compose down

build:
	docker-compose build

rebuild:
	docker-compose build --no-cache

logs:
	docker-compose logs -f

logs-php:
	docker-compose logs -f php

logs-nginx:
	docker-compose logs -f nginx

logs-frontend:
	docker-compose logs -f frontend

php-shell:
	docker-compose exec php /bin/sh

db-shell:
	docker-compose exec postgres psql -U postgres -d postgres

migrate:
	docker-compose exec php php artisan migrate

migrate-fresh:
	docker-compose exec php php artisan migrate:fresh --seed

seed:
	docker-compose exec php php artisan db:seed

test:
	docker-compose exec php php artisan test

tinker:
	docker-compose exec php php artisan tinker

install-deps:
	docker-compose exec php composer install
	docker-compose exec frontend npm install

ps:
	docker-compose ps

stop:
	docker-compose stop

start:
	docker-compose start
