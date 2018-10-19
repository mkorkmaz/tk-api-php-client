<?php

namespace TK\Test\Unit\Factory;

use TK\SDK\ValueObject\Factory\GetTimetableParametersFactory;
use TK\SDK\ValueObject\GetTimetableParameters;

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
     */
    public function shouldReturnGetTimetableParameters() : void
    {
        $json =<<<HEREDOC
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
HEREDOC;
        $parameterObject = GetTimetableParametersFactory::createFromJson($json);
        $this->assertInstanceOf(GetTimetableParameters::class, $parameterObject);
        $this->assertEquals(json_decode($json, true), $parameterObject->getValue());
    }
}
