<?php
declare(strict_types=1);

namespace TK\Test\Unit\Endpoint;

use DateTimeImmutable;
use TK\SDK\ValueObject;

class GetTimeTableTest extends EndpointAbstract
{
    /**
     * @test
     */
    public function shouldGetResponseSuccessfully() : void
    {
        $departureTime = gmdate('Y-m-d H:i:s', strtotime('+4 days'));
        $originLocation = new ValueObject\Location('IST', true);
        $destinationLocation  = new ValueObject\Location('JFK', true);
        $departureDateTime = new ValueObject\DepartureDateTime(
            new DateTimeImmutable($departureTime),
            'P3D',
            'P3D'
        );
        $originDestinationInformation = new ValueObject\OriginDestinationInformation(
            $departureDateTime,
            $originLocation,
            $destinationLocation
        );
        $airScheduleRQ = (new ValueObject\AirScheduleRQ($originDestinationInformation))
            ->withAirlineCode(ValueObject\AirScheduleRQ::AIRLINE_TURKISH_AIRLINES)
            ->withDirectAndNonStopOnlyInd();
        $getTimetableParameters = new ValueObject\GetTimetableParameters(
            $airScheduleRQ,
            ValueObject\GetTimetableParameters::SCHEDULE_TYPE_WEEKLY,
            ValueObject\GetTimetableParameters::TRIP_TYPE_ONE_WAY
        );
        $response = $this->client->getTimetable($getTimetableParameters);
        $this->assertEquals(200, $response['status']);
        $this->assertEquals('SUCCESS', $response['data']['status']);
        $this->assertEquals('TK-0000', $response['data']['message']['code']);
    }
}
