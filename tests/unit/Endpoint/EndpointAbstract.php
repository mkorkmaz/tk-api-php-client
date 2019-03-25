<?php
declare(strict_types=1);

namespace TK\Test\Unit\Endpoint;

use Dotenv;
use Monolog\Handler\StreamHandler;
use TK\API\ClientBuilder;
use Monolog\Logger;
use Monolog\Handler\NullHandler;

abstract class EndpointAbstract extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $client;
    
    protected function _before()
    {
        $logger = new Logger('my_logger');
        $logger->pushHandler(new NullHandler());
        if (file_exists(__DIR__.'/../../../.env')) {
            $dotFilePath = __DIR__.'/../../..';
            $dotenv = new Dotenv\Dotenv($dotFilePath);
            $dotenv->load();
            $logger->pushHandler(new StreamHandler($dotFilePath . '/tests/_output/client.log'));
        }

        $this->client = ClientBuilder::create()
            ->setEnvironment(
                getenv('TK_API_URL'),
                getenv('TK_API_KEY'),
                getenv('TK_API_SECRET'),
                getenv('TK_API_USERNAME')
            )
            ->setLogger($logger)
            ->build();
    }

    protected function _after()
    {
    }
}
