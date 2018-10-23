<?php
declare(strict_types=1);

namespace TK\Test\Unit;

use TK\SDK\ValueObject\Factory\RetrieveReservationDetailParametersFactory;
use TK\SDK\ClientBuilder;
use Dotenv;

class ClientTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    private $client;
    
    protected function _before()
    {
        if (file_exists(__DIR__.'/../../.env')) {
            $dotFile = __DIR__.'/../..';
            $dotenv = new Dotenv\Dotenv($dotFile);
            $dotenv->load();
        }
        $this->client = ClientBuilder::create()
            ->setEnvironment(getenv('TK_API_URL'), getenv('TK_API_KEY'), getenv('TK_API_SECRET'))
            ->setLogger()
            ->build();
    }

    protected function _after()
    {
    }

    /**
     * @test
     * @expectedException \TK\SDK\Exception\RequestException
     */
    public function shouldThrowExceptionForFailure() : void
    {

        $json =<<<JSON
{
    "UniqueId": "INVALID_ID",
    "Surname": "INVALID_SURNAME"
}
JSON;
        $parameterObject = RetrieveReservationDetailParametersFactory::createFromJson($json);
        $this->client->retrieveReservationDetail($parameterObject);
    }

    /**
     * @test
     * @expectedException \TK\SDK\Exception\BadMethodCallException
     */
    public function shouldThrowExceptionForInvalidEndpoint() : void
    {
        $this->client->invalidEndpoint([]);
    }

    /**
     * @test
     * @expectedException \TK\SDK\Exception\InvalidArgumentException
     */
    public function shouldThrowExceptionForInvalidArgument() : void
    {
        $this->client->retrieveReservationDetail([]);
    }
}