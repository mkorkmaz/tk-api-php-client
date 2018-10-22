<?php
declare(strict_types=1);

namespace TK\Test\Unit\Endpoint;

use Dotenv;
use TK\SDK\ClientBuilder;
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
        if (file_exists(__DIR__.'/../../../.env')) {
            $dotFile = __DIR__.'/../../..';
            $dotenv = new Dotenv\Dotenv($dotFile);
            $dotenv->load();
        }
        $logger = new Logger('my_logger');
        $logger->pushHandler(new NullHandler());
        $this->client = ClientBuilder::create()
            ->setEnvironment(getenv('TK_API_URL'), getenv('TK_API_KEY'), getenv('TK_API_SECRET'))
            ->setLogger($logger)
            ->build();
    }

    protected function _after()
    {
    }
}
