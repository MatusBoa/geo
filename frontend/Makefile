PROJECT_NAME := geotest-web-app
COMPOSE_FILE := .devstack/docker-compose.yml

install:
	docker compose -f $(COMPOSE_FILE) -p $(PROJECT_NAME) run --rm node npm install

run:
	docker compose -f $(COMPOSE_FILE) -p $(PROJECT_NAME) run --rm node sh

serve:
	docker compose -f $(COMPOSE_FILE) -p $(PROJECT_NAME) run --rm --service-ports node npm run dev
