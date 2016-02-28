doc:
	@phpdoc --template responsive-twig -d src -t docs/api

install:
	@composer install --dev
