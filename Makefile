build:
	docker compose build

start:
	docker compose up -d

migrate:
	docker compose exec app php artisan migrate

clean:
	docker compose down

db-connect:
	docker compose exec postgres psql --user battleship