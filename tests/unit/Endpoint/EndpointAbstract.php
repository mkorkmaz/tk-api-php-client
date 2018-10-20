<?php
declare(strict_types=1);

namespace TK\Test\Unit\Endpoint;

use Dotenv;
use TK\SDK\ClientBuilder;

abstract class EndpointAbstract extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $client;
    
    protected function _before()
    {
        ini_set('xdebug.overload_var_dump', '0');
        if (file_exists(__DIR__.'/../../../.env')) {
            $dotFile = __DIR__.'/../../..';
            $dotenv = new Dotenv\Dotenv($dotFile);
            $dotenv->load();
        }
        $this->client = ClientBuilder::create()
            ->setEnvironment(getenv('TK_API_URL'), getenv('TK_API_KEY'), getenv('TK_API_SECRET'))
            ->build();
    }

    protected function _after()
    {
    }
}
