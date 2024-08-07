CACHE_DIR = .cldr-cache
PHPUNIT = vendor/bin/phpunit

vendor:
	@composer install
	@rm -rf vendor/icanboogie/cldr
	@composer install --prefer-install=source

# testing

.PHONY: warm-up
warm-up:
	mkdir -p .cldr-cache
	./cldr warm-up -vvv de en en-001 fr fr-BE ja

.cldr-cache: warm-up

.PHONY: test-dependencies
test-dependencies: vendor .cldr-cache

.PHONY: test
test: test-dependencies
	$(PHPUNIT)

.PHONY: test-container
test-container: test-container-81

.PHONY: test-container-81
test-container-81:
	@-docker-compose run --rm app81 bash
	@docker-compose down -v

.PHONY: test-container-82
test-container-82:
	@-docker-compose run --rm app82 bash
	@docker-compose down -v

.PHONY: test-container-83
test-container-83:
	@-docker-compose run --rm app83 bash
	@docker-compose down -v

.PHONY: lint
lint:
	@XDEBUG_MODE=off phpcs -s
	@XDEBUG_MODE=off vendor/bin/phpstan
