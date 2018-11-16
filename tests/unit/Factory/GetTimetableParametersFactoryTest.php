<?php
declare(strict_types=1);

namespace TK\Test\Unit\Factory;

use TK\API\Exception\InvalidArgumentException;
use TK\API\ValueObject\Factory\GetTimetableParametersFactory;
use TK\API\ValueObject\GetTimetableParameters;

class GetTimetableParametersFactoryTest extends \Codeception\Test\Unit
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
  "OTA_AirScheduleRQ":{
    "OriginDestinationInformation":{
      "DepartureDateTime":{
        "WindowAfter":"P3D",
        "WindowBefore":"P3D",
        "Date":"2017-10-14"
      },
      "OriginLocation":{
        "LocationCode":"IST",
        "MultiAirportCityInd":true
      },
      "DestinationLocation":{
        "LocationCode":"ESB",
        "MultiAirportCityInd":false
      }
    },
    "AirlineCode":"TK",
    "FlightTypePref":{
      "DirectAndNonStopOnlyInd":true
    }
  },
  "returnDate":"2017-10-20",
  "scheduleType":"W",
  "tripType":"R"
}
JSON;
        $parameterObject = GetTimetableParametersFactory::createFromJson($json);
        $this->assertInstanceOf(GetTimetableParameters::class, $parameterObject);
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
  "OTA_AirScheduleRQ:{
    "OriginDestinationInformation":{
      "DepartureDateTime":{
        "WindowAfter":"P3D",
        "WindowBefore":"P3D",
        "Date":"2017-10-14"
      },
      "OriginLocation":{
        "LocationCode":"IST",
        "MultiAirportCityInd":true
      },
      "DestinationLocation":{
        "LocationCode":"ESB",
        "MultiAirportCityInd":false
      }
    },
    "AirlineCode":"TK",
    "FlightTypePref":{
      "DirectAndNonStopOnlyInd":true
    }
  },
  "returnDate":"2017-10-20",
  "scheduleType":"W",
  "tripType":"R"
}
JSON;
        GetTimetableParametersFactory::createFromJson($json);
    }
}
