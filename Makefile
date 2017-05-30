.PHONY: tests clear

tests: clear
	vendor/bin/tester tests/ -p php -c tests/php.ini

acceptance: codecept.phar
	php www/index.php orm:schema-tool:create --dump-sql > tests/_data/dump_create.sql
	cat tests/_data/dump_create.sql > tests/_data/dump.sql
	cat tests/_data/dump_data.sql >> tests/_data/dump.sql
	php codecept.phar run --steps

codecept.phar:
	wget http://codeception.com/codecept.phar

clear:
	php www/index.php orm:schema-tool:drop --force
	php www/index.php orm:schema-tool:create