DOCKER_COMPOSE=docker compose -f docker/docker-compose.yml
DOCKER_COMPOSE_EXEC=${DOCKER_COMPOSE} exec app
CODE_ANALYZER=docker run -v ${PWD}:/code --rm ghcr.io/phpstan/phpstan:latest-php8.1 analyse -a /code/vendor/autoload.php
CODE_ANALYZER_WITH_PATH=${CODE_ANALYZER} /code/tests /code/app /code/database --configuration=/code/phpstan.neon

help: # Show help for each of the Makefile recipes.
	@grep -E '^[a-zA-Z0-9 -]+:.*#'  Makefile | sort | while read -r l; do printf "\033[1;32m$$(echo $$l | cut -f 1 -d':')\033[00m:$$(echo $$l | cut -f 2- -d'#')\n"; done

test_env_up: # Levanta el contenedor de php para testing
	${DOCKER_COMPOSE} up app -d

mysql_up: # Levantamos el contenedor de mysql
	${DOCKER_COMPOSE} up db -d
	echo "Esperando aprovisionamiento de base de datos"
	sleep 10

tests: tests test_env_up # Lanza la suits de test con cobertura
	${CODE_ANALYZER_WITH_PATH} --level 5
	${DOCKER_COMPOSE_EXEC} bash -c "XDEBUG_MODE=coverage ./artisan test --coverage --coverage-html coverage"

artisan: test_env_up # Lanza comandos de artisan con argumentos como make artisan $ARGS="about"
	${DOCKER_COMPOSE_EXEC} ./artisan ${ARGS}

migration: test_env_up mysql_up # Lanzamos migraciones mediante artisan
	${DOCKER_COMPOSE_EXEC} ./artisan "migrate"

phpstan_generate_baseline: # Genera un fichero para omitir ciertos avisos del analizador
	${CODE_ANALYZER_WITH_PATH} --level 5 --generate-baseline /code/phpstan-baseline.neon
