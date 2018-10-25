<?php
declare(strict_types=1);

namespace TK\Test\Unit\Endpoint;

use DateTimeImmutable;
use TK\SDK\Exception\InvalidArgumentException;
use TK\SDK\ValueObject;

class GetAvailabilityTest extends EndpointAbstract
{
    /**
     * @test
     */
    public function shouldGetResponseSuccessfully() : void
    {
        $departureTime = gmdate('Y-m-d H:i:s', strtotime('+4 days'));
        $originLocation = new ValueObject\Location('IST', true);
        $destinationLocation  = new ValueObject\Location('ESB', true);
        $departureDateTime = (new ValueObject\DepartureDateTime(
            new DateTimeImmutable($departureTime),
            'P3D',
            'P3D'
        ))->withDateFormat('dM');
        $originDestinationInformation = (new ValueObject\OriginDestinationInformation(
            $departureDateTime,
            $originLocation,
            $destinationLocation
        ))->withCabinPreferences(ValueObject\OriginDestinationInformation::CABIN_PREFERENCE_ECONOMY);
        $passengerTypeQuantity = (new ValueObject\PassengerTypeQuantity())
            ->withQuantity(ValueObject\PassengerTypeQuantity::PASSENGER_TYPE_ADULT, 1)
            ->withQuantity(ValueObject\PassengerTypeQuantity::PASSENGER_TYPE_CHILD, 2);
        $getAvailabilityParameters = new ValueObject\GetAvailabilityParameters(
            ValueObject\GetAvailabilityParameters::REDUCED_DATA_INDICATOR_FALSE,
            ValueObject\GetAvailabilityParameters::ROUTING_TYPE_ONE_WAY,
            $passengerTypeQuantity
        );
        $getAvailabilityParameters =
            $getAvailabilityParameters->withOriginDestinationInformation($originDestinationInformation)
            ->withTargetSource();
        $response = $this->client->getAvailability($getAvailabilityParameters);
        $this->assertEquals(200, $response['status']);
        $this->assertEquals('SUCCESS', $response['response']['status']);
        $this->assertEquals('TK-0000', $response['response']['code']);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function shouldFailForInvalidPassengerType() : void
    {
        $departureTime = gmdate('Y-m-d H:i:s', strtotime('+4 days'));
        $originLocation = new ValueObject\Location('IST', true);
        $destinationLocation  = new ValueObject\Location('ESB', true);
        $departureDateTime = (new ValueObject\DepartureDateTime(
            new DateTimeImmutable($departureTime),
            'P3D',
            'P3D'
        ))->withDateFormat('dM');
        (new ValueObject\OriginDestinationInformation(
            $departureDateTime,
            $originLocation,
            $destinationLocation
        ))->withCabinPreferences(ValueObject\OriginDestinationInformation::CABIN_PREFERENCE_ECONOMY);
        (new ValueObject\PassengerTypeQuantity())
            ->withQuantity('none', 1);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function shouldFailForInvalidCabinPreferences() : void
    {
        $departureTime = gmdate('Y-m-d H:i:s', strtotime('+4 days'));
        $originLocation = new ValueObject\Location('IST', true);
        $destinationLocation  = new ValueObject\Location('ESB', true);
        $departureDateTime = (new ValueObject\DepartureDateTime(
            new DateTimeImmutable($departureTime),
            'P3D',
            'P3D'
        ))->withDateFormat('dM');
        (new ValueObject\OriginDestinationInformation(
            $departureDateTime,
            $originLocation,
            $destinationLocation
        ))->withCabinPreferences('N');
    }
}
