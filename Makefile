include .env

ms-start:
	docker-compose --file=./docker-compose.yml --env-file=./.env up -d --remove-orphan --build
ms-down:
	docker-compose --file=./docker-compose.yml --env-file=./.env down --remove-orphans
ms-stop:
	docker-compose --file=./docker-compose.yml --env-file=./.env stop
ms-restart:
	make ms-down
	make ms-start
ms-cli:
	docker exec -it ${APP_NAME}-php-fpm-cli /bin/bash
ms-db:
	docker exec -it order_postgres_1 /bin/bash
