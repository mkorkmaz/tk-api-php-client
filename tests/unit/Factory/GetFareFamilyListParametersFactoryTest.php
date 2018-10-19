<?php
declare(strict_types=1);

namespace TK\Test\Unit\Factory;

use TK\SDK\ValueObject\Factory\GetFareFamilyListParametersFactory;
use TK\SDK\ValueObject\GetFareFamilyListParameters;

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
    public function shouldReturnCalculateFlightMilesParameters() : void
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
}
