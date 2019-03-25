<?php
declare(strict_types=1);

namespace TK\Test\Unit;

use TK\API\Exception\RequestException;
use TK\API\Client;
use TK\API\ValueObject\Factory\RetrieveReservationDetailParametersFactory;
use TK\API\ClientBuilder;
use TK\Test\Unit\Resources\ExampleEndpoint;
use Dotenv;
use ReflectionMethod;

class ClientTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var Client
     */
    private $client;
    
    protected function _before()
    {
        if (file_exists(__DIR__.'/../../.env')) {
            $dotFile = __DIR__.'/../..';
            $dotenv = new Dotenv\Dotenv($dotFile);
            $dotenv->load();
        }
        $this->client = ClientBuilder::create()
            ->setEnvironment(
                getenv('TK_API_URL'),
                getenv('TK_API_KEY'),
                getenv('TK_API_SECRET'),
                getenv('TK_API_USERNAME'),
                'MOBILE'
            )
            ->setLogger()
            ->build();
    }

    protected function _after()
    {
    }

    /**
     * @test
     * @expectedException \TK\API\Exception\RequestException
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
     * @expectedException \TK\API\Exception\BadMethodCallException
     */
    public function shouldThrowExceptionForInvalidEndpoint() : void
    {
        $this->client->invalidEndpoint([]);
    }

    /**
     * @test
     * @expectedException \TK\API\Exception\InvalidArgumentException
     */
    public function shouldThrowExceptionForInvalidArgument() : void
    {
        $this->client->retrieveReservationDetail([]);
    }

    /**
     * @test
     * @expectedException \TK\API\Exception\RequestException
     */
    public function shouldThrowExceptionForGuzzleRequestError() : void
    {
        $endpoint = new ExampleEndpoint();

        $httpRequest = new ReflectionMethod($this->client, 'httpRequest');
        $httpRequest->setAccessible(true);
        $httpRequest->invoke($this->client, $endpoint);
    }
}
