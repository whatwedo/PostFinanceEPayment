doc:
	phpdoc --template responsive-twig -d src -t docs/api

install:
	composer install --dev

test_docker:
	if [ ! -a phpunit.xml ]; then cp phpunit.xml.dist phpunit.xml; fi;
	docker run -i -v $(PWD):/app composer/composer install
	docker run -i -v $(PWD):/app -w /app php:5.6 vendor/bin/phpunit -c phpunit.xml
	docker run -i -v $(PWD):/app -w /app php:7.0 vendor/bin/phpunit -c phpunit.xml
	docker run -i -v $(PWD):/app -w /app php:7.1 vendor/bin/phpunit -c phpunit.xml
	docker run -i -v $(PWD):/app -w /app hhvm/hhvm vendor/bin/phpunit -c phpunit.xml
