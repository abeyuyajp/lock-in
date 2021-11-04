up:
	docker-compose up -d
build:
	docker-compose build --no-cache --force-rm
stop:
	docker-compose stop
down:
	docker-compose down --remove-orphans
ps:
	docker-compose ps
web:
	docker-compose exec web ash
app:
	docker-compose exec app bash
migrate:
	docker-compose exec app php artisan migrate
tinker:
	docker-compose exec app php artisan tinker
optimize:
	docker-compose exec app php artisan optimize
cache-clear:
	docker compose exec app composer clear-cache
	@make optimize-clear
	docker compose exec app php artisan event:clear