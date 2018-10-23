<?php
declare(strict_types=1);

namespace TK\Test\Unit\Factory;

use TK\SDK\Exception\InvalidArgumentException;
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
    public function shouldReturnCalculateAwardMilesWithTaxParametersObjectSuccessfully() : void
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
    "departureDateYear": 2017,
    "ptcType": "FFY"
}
JSON;
        $parameterObject = CalculateAwardMilesWithTaxParametersFactory::createFromJson($json);
        $this->assertInstanceOf(CalculateAwardMilesWithTaxParameters::class, $parameterObject);
        $this->assertEquals(json_decode($json, true), $parameterObject->getValue());
    }


    /**
     * @test
     * @throws \Exception
     */
    public function shouldReturnCalculateAwardMilesWithTaxParametersObjectSuccessfullyForArrival() : void
    {
        $year = ((int) date('Y')) +1;
        $json =<<<JSON
{
    "awardType": "E",
    "wantMoreMiles": "T",
    "isOneWay": "T",
    "arrivalOrigin": "IST",
    "arrivalDestination": "FRA",
    "arrivalDateDay": 12,
    "arrivalDateMonth": 11,
    "arrivalDateYear": {$year}
}
JSON;
        $parameterObject = CalculateAwardMilesWithTaxParametersFactory::createFromJson($json);
        $this->assertInstanceOf(CalculateAwardMilesWithTaxParameters::class, $parameterObject);
        $this->assertEquals(json_decode($json, true), $parameterObject->getValue());
    }


    /**
     * @test
     */
    public function shouldFailForInvalidAwardTypeSuccessfully() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $json =<<<JSON
{
    "awardType": "Z",
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
    }

    /**
     * @test
     */
    public function shouldFailForInvalidIataCodeSuccessfully() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $json =<<<JSON
{
    "awardType": "E",
    "wantMoreMiles": "T",
    "isOneWay": "T",
    "departureOrigin": "ICAO",
    "departureDestination": "FRA",
    "departureDateDay": 12,
    "departureDateMonth": 11,
    "departureDateYear": 2017
}
JSON;
         CalculateAwardMilesWithTaxParametersFactory::createFromJson($json);
    }


    /**
     * @test
     */
    public function shouldFailForInvalidJson() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $json =<<<JSON
{
    "awardType: "E",
    "wantMoreMiles": "T",
    "isOneWay": "T",
    "departureOrigin": "ICAO",
    "departureDestination": "FRA",
    "departureDateDay": 12,
    "departureDateMonth": 11,
    "departureDateYear": 2017
}
JSON;
        CalculateAwardMilesWithTaxParametersFactory::createFromJson($json);
    }
}
