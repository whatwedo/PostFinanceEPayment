doc:
	phpdoc --template responsive-twig -d src -t docs/api

install:
	composer install --dev

test_docker:
	if [ ! -a phpunit.xml ]; then cp phpunit.xml.dist phpunit.xml; fi;
	docker run -i -v $(PWD):/app composer/composer install
	docker run -i -v $(PWD):/app phpunit/phpunit:5.7.12 -c phpunit.xml
