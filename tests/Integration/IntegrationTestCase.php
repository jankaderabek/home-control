<?php declare(strict_types=1);

namespace Tests\Integration;

use Doctrine\DBAL\Connection;
use Kdyby\Doctrine\Helpers;
use Nette\Configurator;
use Nette\DI\Container;
use Tester\TestCase;

class IntegrationTestCase extends TestCase
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var string
     */
    private $databaseName;

    /**
     * @var Connection
     */
    private $serverConnection;

    protected function getContainer(): Container
    {
        if ($this->container === null) {
            $this->container = $this->createContainer();
        }

        return $this->container;
    }

    private function createContainer(): Container
    {
        $configurator = new Configurator();
        $configurator->setDebugMode(FALSE);
        $configurator->setTempDirectory(TEMP_DIR);

        $configurator->addConfig(APP_DIR . '/config/config.neon');
        $configurator->addConfig(APP_DIR . '/config/config.local.neon');

        $configurator->addParameters([
            'appDir' => APP_DIR,
        ]);

        $container = $configurator->createContainer();

        $this->prepareDatabase($container);

        return $container;
    }

    private function prepareDatabase(Container $container)
    {
        /** @var \Kdyby\Doctrine\Connection $existingDoctrineConnection */
        $existingDoctrineConnection = $container->getByType(\Kdyby\Doctrine\Connection::class);

        $this->databaseName = 'home_control_test' . getmypid();
        $this->serverConnection = $existingDoctrineConnection;

        $sql = 'CREATE DATABASE ' . $this->databaseName . ' COLLATE "utf8_general_ci";';
        $this->serverConnection->exec($sql);
        $this->serverConnection->exec('USE ' . $this->databaseName);

        Helpers::loadFromFile($this->serverConnection, TEST_DIR . '/_data/dump_create.sql');
    }

    protected function tearDown()
    {
        parent::tearDown();
        if ($this->serverConnection) {
            $this->serverConnection->query('DROP DATABASE IF EXISTS ' . $this->databaseName);
        }
    }
}