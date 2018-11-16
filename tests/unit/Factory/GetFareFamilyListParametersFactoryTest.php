<?php
declare(strict_types=1);

namespace TK\Test\Unit\Factory;

use TK\API\Exception\InvalidArgumentException;
use TK\API\ValueObject\Factory\GetFareFamilyListParametersFactory;
use TK\API\ValueObject\GetFareFamilyListParameters;

class GetFareFamilyListParametersFactoryTest extends \Codeception\Test\Unit
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
    public function shouldReturnGetFareFamilyListParameters() : void
    {
        $json =<<<JSON
{
    "portList":[
        "IST",
        "JFK"
    ],
    "isMilesRequest" : "T"
}
JSON;
        $parameterObject = GetFareFamilyListParametersFactory::createFromJson($json);
        $this->assertInstanceOf(GetFareFamilyListParameters::class, $parameterObject);
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
    "portList:[
        "IST",
        "JFK"
    ],
    "isMilesRequest" : "T"
}
JSON;
        GetFareFamilyListParametersFactory::createFromJson($json);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function shouldFailForInvalidAirportCode() : void
    {
        $json =<<<JSON
{
    "portList":[
        "ISTT",
        "JFK"
    ],
    "isMilesRequest" : "T"
}
JSON;
        GetFareFamilyListParametersFactory::createFromJson($json);
    }
}
