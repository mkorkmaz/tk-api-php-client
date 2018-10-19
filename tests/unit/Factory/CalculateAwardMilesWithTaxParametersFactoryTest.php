<?php
declare(strict_types=1);

namespace TK\Test\Unit\Factory;

use TK\SDK\ValueObject\Factory\CalculateAwardMilesWithTaxParametersFactory;
use TK\SDK\ValueObject\CalculateAwardMilesWithTaxParameters;

class CalculateAwardMilesWithTaxParametersFactoryTest extends \Codeception\Test\Unit
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
    public function shouldReturnGetTimetableParameters() : void
    {
        $json =<<<JSON
{
	"awardType": "E",
	"wantMoreMiles": "T",
	"isOneWay": "T",
	"departureOrigin": "IST",
	"departureDestination": "FRA",
	"departureDateDay": 12,
	"departureDateMonth": 11,
	"departureDateYear": 2017
}
JSON;
        $parameterObject = CalculateAwardMilesWithTaxParametersFactory::createFromJson($json);
        $this->assertInstanceOf(CalculateAwardMilesWithTaxParameters::class, $parameterObject);
        $this->assertEquals(json_decode($json, true), $parameterObject->getValue());
    }
}
