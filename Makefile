.PHONY: tests clear

tests: clear
	vendor/bin/tester tests/ -p php -c tests/php.ini

acceptance: codecept.phar clear
	php codecept.phar run --steps

codecept.phar:
	wget http://codeception.com/codecept.phar

clear:
	php www/index.php orm:schema-tool:drop --force
	php www/index.php orm:schema-tool:create