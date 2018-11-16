<?php
declare(strict_types=1);

namespace TK\Test\Unit\Factory;

use TK\API\Exception\InvalidArgumentException;
use TK\API\ValueObject\Factory\GetPortListParametersFactory;
use TK\API\ValueObject\GetPortListParameters;

class GetPortListParametersFactoryTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /**
     * @test
     * @throws \Exception
     */
    public function shouldReturnGetPortListParameters() : void
    {
        $json =<<<JSON
{
    "airlineCode": "TK",
    "languageCode": "TR"
}
JSON;
        $parameterObject = GetPortListParametersFactory::createFromJson($json);
        $this->assertInstanceOf(GetPortListParameters::class, $parameterObject);
        $this->assertEquals(json_decode($json, true), $parameterObject->getValue());
    }

    /**
     * @test
     * @throws \Exception
     * @expectedException InvalidArgumentException
     */
    public function shouldFailForInvalidJson() : void
    {
        $json =<<<JSON
{
    "airlineCode: "TK",
    "languageCode": "TR"
}
JSON;
        GetPortListParametersFactory::createFromJson($json);
    }
}
