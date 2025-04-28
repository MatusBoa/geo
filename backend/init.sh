#!/bin/bash

SCRIPT_DIR="$(dirname "$(realpath "${BASH_SOURCE[0]}")")"

dc() {
  local COMMAND=$@

  echo $COMMAND

  docker compose -f $SCRIPT_DIR/docker/docker-compose.yml $COMMAND
}

dc run workspace cp .env.example .env
dc run workspace composer i
dc run workspace php artisan key:generate
dc run workspace php artisan migrate:fresh --seed
dc up -d --remove-orphans