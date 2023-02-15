DOCKER_COMPOSE=docker compose -f docker/docker-compose.yml
DOCKER_COMPOSE_EXEC=${DOCKER_COMPOSE} exec app

help: # Show help for each of the Makefile recipes.
	@grep -E '^[a-zA-Z0-9 -]+:.*#'  Makefile | sort | while read -r l; do printf "\033[1;32m$$(echo $$l | cut -f 1 -d':')\033[00m:$$(echo $$l | cut -f 2- -d'#')\n"; done

test_env_up: # Levanta el contenedor de php para testing
	${DOCKER_COMPOSE} up app -d

tests: tests test_env_up # Lanza la suits de test con cobertura
	${DOCKER_COMPOSE_EXEC} bash -c "XDEBUG_MODE=coverage ./artisan test --coverage"

artisan: test_env_up # Lanza comandos de artisan con argumentos como make artisan $ARGS="about"
	${DOCKER_COMPOSE_EXEC} ./artisan ${ARGS}
