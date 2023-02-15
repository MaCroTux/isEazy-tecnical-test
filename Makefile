DOCKER_COMPOSE=docker compose -f docker/docker-compose.yml
DOCKER_COMPOSE_EXEC=${DOCKER_COMPOSE} exec app

test_env_up:
	${DOCKER_COMPOSE} up app -d

tests: tests test_env_up
	${DOCKER_COMPOSE_EXEC} bash -c "XDEBUG_MODE=coverage ./artisan test --coverage"
