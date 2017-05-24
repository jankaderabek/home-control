.PHONY: tests

tests:
	php www/index.php orm:schema-tool:drop --force
	php www/index.php orm:schema-tool:create
	vendor/bin/tester tests/ -p php -c tests/php.ini
