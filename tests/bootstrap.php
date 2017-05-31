<?php

require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();

define('TEST_DIR', __DIR__);
define('ROOT_DIR', realpath(__DIR__ . "/.."));
define('APP_DIR', ROOT_DIR . "/app");
define('TEMP_DIR', TEST_DIR . "/temp/" . getmypid());

Tester\Helpers::purge(TEMP_DIR);