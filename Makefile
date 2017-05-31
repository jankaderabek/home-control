.PHONY: tests clear

tests: create-schema
	vendor/bin/tester tests/ -p php -c tests/php.ini

acceptance: codecept.phar create-schema prepare-dumps
	php codecept.phar run --steps

acceptance-travis: codecept.phar create-schema prepare-dumps
	php codecept.phar run --env travis

prepare-dumps:
	cat tests/_data/dump_create.sql > tests/_data/dump.sql
	cat tests/_data/dump_data.sql >> tests/_data/dump.sql

create-schema:
	php www/index.php orm:schema-tool:create --dump-sql > tests/_data/dump_create.sql

codecept.phar:
	wget http://codeception.com/codecept.phar

clear:
	php www/index.php orm:schema-tool:drop --force
	php www/index.php orm:schema-tool:create