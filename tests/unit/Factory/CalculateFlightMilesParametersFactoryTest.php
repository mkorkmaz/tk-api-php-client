<?php
declare(strict_types=1);

namespace TK\Test\Unit\Factory;

use TK\API\Exception\InvalidArgumentException;
use TK\API\ValueObject\Factory\CalculateFlightMilesParametersFactory;
use TK\API\ValueObject\CalculateFlightMilesParameters;

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
    "marketingClassCode": "TK",
    "marketingFlightNumber":"TK1000",
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

    /**
     * @test
     * @throws \Exception
     */
    public function shouldReturnCalculateFlightMilesParametersWithClassCode() : void
    {
        $json =<<<JSON
{
    "cabin_code": "Y",
    "card_type": "EP",
    "class_code": "T",
    "marketingClassCode": "TK",
    "marketingFlightNumber":"TK1000",
    "destination": "IST",
    "flightDate": "21.04.2017",
    "operatingFlightNumber": "TK1000",
    "origin": "FRA"
}

JSON;
        $parameterObject = CalculateFlightMilesParametersFactory::createFromJson($json);
        $parameterObject->withClassCode();
        $this->assertInstanceOf(CalculateFlightMilesParameters::class, $parameterObject);
        $this->assertArrayHasKey('class_code', $parameterObject->getValue());
    }
    /**
     * @test
     * @throws \Exception
     * @expectedException InvalidArgumentException
     */
    public function shouldFailForInvalidCardTypesEnum() : void
    {
        $json =<<<JSON
{
    "cabin_code": "Y",
    "card_type": "TT",
    "class_code": "Y",
    "marketingClassCode": "TK",
    "marketingFlightNumber":"TK1000",
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



    /**
     * @test
     * @throws \Exception
     * @expectedException InvalidArgumentException
     */
    public function shouldFailForInvalidOrigin() : void
    {
        $json =<<<JSON
{
    "cabin_code": "Y",
    "card_type": "TT",
    "class_code": "Y",
    "marketingClassCode": "TK",
    "marketingFlightNumber":"TK1000",
    "destination": "IST",
    "flightDate": "21.04.2017",
    "operatingFlightNumber": "TK1000",
    "origin": "FRAT"
}

JSON;
        CalculateFlightMilesParametersFactory::createFromJson($json);
    }



    /**
     * @test
     * @throws \Exception
     * @expectedException InvalidArgumentException
     */
    public function shouldFailForInvalidDestination() : void
    {
        $json =<<<JSON
{
    "cabin_code": "Y",
    "card_type": "TT",
    "class_code": "Y",
    "marketingClassCode": "TK",
    "marketingFlightNumber":"TK1000",
    "destination": "ISTT",
    "flightDate": "21.04.2017",
    "operatingFlightNumber": "TK1000",
    "origin": "FRA"
}

JSON;
        CalculateFlightMilesParametersFactory::createFromJson($json);
    }


    /**
     * @test
     */
    public function shouldFailForInvalidJsony() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $json =<<<JSON
{
    "cabin_code: "Y",
    "card_type": "TT",
    "class_code": "Y",
    "marketingClassCode": "TK",
    "marketingFlightNumber":"TK1000",
    "destination": "ISTT",
    "flightDate": "21.04.2017",
    "operatingFlightNumber": "TK1000",
    "origin": "FRA"
}

JSON;
        CalculateFlightMilesParametersFactory::createFromJson($json);
    }
}
