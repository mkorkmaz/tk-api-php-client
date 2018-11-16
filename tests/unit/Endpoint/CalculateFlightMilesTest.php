<?php
declare(strict_types=1);

namespace TK\Test\Unit\Endpoint;

use DateTimeImmutable;
use TK\API\ValueObject;

class CalculateFlightMilesTest extends EndpointAbstract
{
    /**
     * @test
     */
    public function shouldGetResponseSuccessfully() : void
    {
        $flightDate = gmdate('Y-m-d H:i:s', strtotime('+4 days'));

        $calculateFlightMilesParameters = (new ValueObject\CalculateFlightMilesParameters(
            'IST',
            'JFK'
        ))->withCabinCode()
        ->withCardType('EP')
        ->withOperatingFlightNumber('TK1')
        ->withFlightDate(new DateTimeImmutable($flightDate));
        $response = $this->client->calculateFlightMiles($calculateFlightMilesParameters);
        $this->assertEquals(200, $response['status']);
        $this->assertEquals('SUCCESS', $response['response']['status']);
        $this->assertEquals('TK-0000', $response['response']['code']);
    }
}
