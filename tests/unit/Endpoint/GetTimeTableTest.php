<?php
declare(strict_types=1);

namespace TK\Test\Unit\Endpoint;

use DateTimeImmutable;
use TK\API\ValueObject;

class GetTimeTableTest extends EndpointAbstract
{
    /**
     * @test
     */
    public function shouldGetResponseSuccessfully() : void
    {
        $departureTime = gmdate('Y-m-d H:i:s', strtotime('+4 days'));
        $originLocation = new ValueObject\Location('IST', ValueObject\Location::MULTIPLE_AIRPORT_TRUE);
        $destinationLocation  = new ValueObject\Location('JFK', ValueObject\Location::MULTIPLE_AIRPORT_TRUE);
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
        $this->assertEquals('SUCCESS', $response['response']['status']);
        $this->assertEquals('TK-0000', $response['response']['code']);
    }

    /**
     * @test
     * @expectedException \TK\API\Exception\InvalidArgumentException
     */
    public function shouldFailForInvalidScheduleType() : void
    {
        $departureTime = gmdate('Y-m-d H:i:s', strtotime('+4 days'));
        $originLocation = new ValueObject\Location('IST', ValueObject\Location::MULTIPLE_AIRPORT_TRUE);
        $destinationLocation  = new ValueObject\Location('JFK', ValueObject\Location::MULTIPLE_AIRPORT_TRUE);
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
        new ValueObject\GetTimetableParameters(
            $airScheduleRQ,
            'N',
            ValueObject\GetTimetableParameters::TRIP_TYPE_ONE_WAY
        );
    }

    /**
     * @test
     * @expectedException \TK\API\Exception\InvalidArgumentException
     */
    public function shouldFailForInvalidAirportCode() : void
    {
        $departureTime = gmdate('Y-m-d H:i:s', strtotime('+4 days'));
        $originLocation = new ValueObject\Location('IST', ValueObject\Location::MULTIPLE_AIRPORT_TRUE);
        $destinationLocation  = new ValueObject\Location('JFK', ValueObject\Location::MULTIPLE_AIRPORT_TRUE);
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
            ->withAirlineCode('MK')
            ->withDirectAndNonStopOnlyInd();
        new ValueObject\GetTimetableParameters(
            $airScheduleRQ,
            ValueObject\GetTimetableParameters::SCHEDULE_TYPE_WEEKLY,
            ValueObject\GetTimetableParameters::TRIP_TYPE_ONE_WAY
        );
    }

    /**
     * @test
     * @expectedException \TK\API\Exception\InvalidArgumentException
     */
    public function shouldFailForInvalidLocation() : void
    {
        new ValueObject\Location('ISTT', ValueObject\Location::MULTIPLE_AIRPORT_TRUE);
    }
    /**
     * @test
     * @expectedException \TK\API\Exception\InvalidArgumentException
     */
    public function shouldFailForInvalidDurationWindowAfter() : void
    {
        $departureTime = gmdate('Y-m-d H:i:s', strtotime('+4 days'));
        new ValueObject\DepartureDateTime(
            new DateTimeImmutable($departureTime),
            'P4D',
            'P3D'
        );
    }


    /**
     * @test
     * @expectedException \TK\API\Exception\InvalidArgumentException
     */
    public function shouldFailForInvalidDurationWindowBefore() : void
    {
        $departureTime = gmdate('Y-m-d H:i:s', strtotime('+4 days'));
        new ValueObject\DepartureDateTime(
            new DateTimeImmutable($departureTime),
            'P3D',
            'P4D'
        );
    }

    /**
     * @test
     * @expectedException \TK\API\Exception\InvalidArgumentException
     */
    public function shouldFailForInvalidTripType() : void
    {
        $departureTime = gmdate('Y-m-d H:i:s', strtotime('+4 days'));
        $originLocation = new ValueObject\Location('IST', ValueObject\Location::MULTIPLE_AIRPORT_TRUE);
        $destinationLocation  = new ValueObject\Location('JFK', ValueObject\Location::MULTIPLE_AIRPORT_TRUE);
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
        new ValueObject\GetTimetableParameters(
            $airScheduleRQ,
            ValueObject\GetTimetableParameters::SCHEDULE_TYPE_WEEKLY,
            'n'
        );
    }
}
