<?php
declare(strict_types=1);

namespace TK\Test\Unit\Factory;

use TK\SDK\ValueObject\Factory\GetAvailabilityParametersFactory;
use TK\SDK\ValueObject\GetAvailabilityParameters;

class GetAvailabilityParametersFactoryTest extends \Codeception\Test\Unit
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
    public function shouldReturnGetAvailabilityParameters() : void
    {
        $json =<<<JSON
{
  "ReducedDataIndicator":false,
  "RoutingType":"r",
  "PassengerTypeQuantity":[
    {
      "Code":"adult",
      "Quantity":1
    },
    {
      "Code":"child",
      "Quantity":1
    },
    {
      "Code":"infant",
      "Quantity":0
    }
  ],
  "OriginDestinationInformation":[
    {
      "DepartureDateTime":{
        "WindowAfter":"P0D",
        "WindowBefore":"P0D",
        "Date":"14OCT"
      },
      "OriginLocation":{
        "LocationCode":"IST",
        "MultiAirportCityInd":true
      },
      "DestinationLocation":{
        "LocationCode":"ESB",
        "MultiAirportCityInd":true
      },
      "CabinPreferences":[
        {
          "Cabin":"ECONOMY"
        },
        {
          "Cabin":"BUSINESS"
        }
      ]
    },
    {
      "DepartureDateTime":{
        "WindowAfter":"P0D",
        "WindowBefore":"P0D",
        "Date":"09JAN"
      },
      "OriginLocation":{
        "LocationCode":"ESB",
        "MultiAirportCityInd":false
      },
      "DestinationLocation":{
        "LocationCode":"IST",
        "MultiAirportCityInd":false
      },
      "CabinPreferences":[
        {
          "Cabin":"ECONOMY"
        },
        {
          "Cabin":"BUSINESS"
        }
      ]
    }
  ]
}
JSON;
        $parameterObject = GetAvailabilityParametersFactory::createFromJson($json);
        $this->assertInstanceOf(GetAvailabilityParameters::class, $parameterObject);
        $this->assertEquals(json_decode($json, true), $parameterObject->getValue());
    }
}
