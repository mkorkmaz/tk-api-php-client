<?php
declare(strict_types=1);

namespace TK\Test\Unit\Factory;

use TK\SDK\ValueObject\Factory\CalculateFlightMilesParametersFactory;
use TK\SDK\ValueObject\CalculateFlightMilesParameters;

class CalculateFlightMilesParametersFactoryTest extends \Codeception\Test\Unit
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
	"cabin_code": "Y",
	"card_type": "EP",
	"destination": "IST",
	"flightDate": "21.04.2017",
	"operatingFlightNumber": "TK1000",
	"origin": "FRA"
}
	
JSON;
        $parameterObject = CalculateFlightMilesParametersFactory::createFromJson($json);
        $this->assertInstanceOf(CalculateFlightMilesParameters::class, $parameterObject);
        $this->assertEquals(json_decode($json, true), $parameterObject->getValue());
    }
}
