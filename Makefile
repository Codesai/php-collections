.PHONY: build

build:
	docker-compose build

clean:
	docker-compose down -v

test: clean build
	docker-compose run php php composer.phar run-script tests

shell: clean build
	docker-compose run php sh
