#!/bin/bash

# Copy config files
DOCKER_COMPOSE_FILE="docker-compose.override.yml"
if [ ! -f "$DOCKER_COMPOSE_FILE" ]; then
  cp docker-compose.override.yml.dist docker-compose.override.yml
  echo "$DOCKER_COMPOSE_FILE is copied"
fi

DOCKER_ENV_FILE=".env"
if [ ! -f "$DOCKER_ENV_FILE" ]; then
  cp .env.dist .env
  echo "$DOCKER_ENV_FILE is copied"
fi

SYMFONY_ENV_FILE="app/symfony/.env"
if [ ! -f "$SYMFONY_ENV_FILE" ]; then
  cp app/symfony/.env.dist app/symfony/.env
  echo "$SYMFONY_ENV_FILE is copied"
fi

# build docker compose
docker-compose up --force-recreate --build -d

# install dependencies
docker-compose exec apache sh -c 'composer install'
docker-compose exec apache sh -c 'bin/console assets:install public'

# Create database + update schema
docker-compose exec apache sh -c 'bin/console doctrine:database:create --if-not-exists'
docker-compose exec apache sh -c 'bin/console cache:clear'

# Update var directory permissions
docker-compose exec apache sh -c 'chown -Rf www-data: var/'
