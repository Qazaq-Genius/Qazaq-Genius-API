
CLI = docker-compose -f docker/compose/docker-compose-cli.yml
PHPUNIT = /var/www/html/vendor/bin/phpunit

.PHONY: build_dev
build_dev:
	docker build -f docker/php/Dockerfile . \
	-t qazaq_genius/lyrics_api/php:dev
	docker build -f docker/nginx/Dockerfile . \
	-t qazaq_genius/lyrics_api/nginx:dev
	docker build -f docker/database/Dockerfile . \
	-t qazaq_genius/lyrics_api/database:dev
	docker build -f docker/php_cli/Dockerfile . \
	-t qazaq_genius/lyrics_api/php_cli:dev

.PHONY: run
run:
	docker-compose -f docker/compose/docker-compose-dev.yml up -d

.PHONY: stop
stop:
	docker-compose -f docker/compose/docker-compose-dev.yml down --remove-orphans

.PHONY: install
install:
	$(CLI) run --rm --no-deps php_cli php -d memory_limit=-1 /usr/local/bin/composer install

.PHONY: autoload
autoload:
	$(CLI) run --rm --no-deps php_cli php -d memory_limit=-1 /usr/local/bin/composer dumpautoload

.PHONY: update
update:
	$(CLI) run --rm --no-deps php_cli php -d memory_limit=-1 /usr/local/bin/composer update

.PHONY: logs
logs:
	docker-compose -f docker/compose/docker-compose-dev.yml logs

.PHONY: tests
tests:
	$(CLI) run php_cli php -dxdebug.coverage_enable=1 -dxdebug.mode=coverage $(PHPUNIT) \
                             --coverage-clover tests/reports/coverage/phpunit.coverage.xml \
                             --configuration tests/phpunit.xml
	sed -i "s|/var/www/html|$$(pwd)/code|g" code/tests/reports/coverage/phpunit.coverage.xml #replace docker folder path with out
	git update-index --assume-unchanged code/tests/reports/coverage/phpunit.coverage.xml #ignore changes in the coverage file, but keep in version control

.PHONY: sniff
sniff:  install ##code sniffer will be executed
	@echo ""
	@echo "+++++ SNIFFER +++++"
	set -e
	set -e
	$(CLI) run php_cli /bin/sh -c "vendor/bin/phpcs -w -p -s --standard=vendor/flyeralarm/php-code-validator/ruleset.xml src/ tests/"

.PHONY: sniffer_fix
sniffer_fix: install ##automatic fixing of some code style errors
	@echo ""
	@echo "+++++ SNIFFER FIXER+++++"
	set -e
	$(CLI) run php_cli /bin/sh -c "vendor/bin/phpcbf --standard=vendor/flyeralarm/php-code-validator/ruleset.xml src/ tests/"
	docker-compose down -v --remove-orphans

