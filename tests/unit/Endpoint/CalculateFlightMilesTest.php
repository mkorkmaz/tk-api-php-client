<?php
declare(strict_types=1);

namespace TK\Test\Unit\Endpoint;

use DateTimeImmutable;
use TK\SDK\ValueObject;

class CalculateFlightMilesTest extends EndpointAbstract
{
    /**
     * @test
     */
    public function shouldGetResponseSuccessfully() : void
    {
        $flightDate = gmdate('Y-m-d H:i:s', strtotime('+4 days'));

        $calculateFlightMilesParameters = (new ValueObject\CalculateFlightMilesParameters(
            'FRA',
            'IST'
        ))->withCabinCode()
        ->withCardType('EP')
        ->withOperatingFlightNumber('TK1000')
        ->withFlightDate(new DateTimeImmutable($flightDate));
        $response = $this->client->calculateFlightMiles($calculateFlightMilesParameters);
        $this->assertEquals(200, $response['status']);
        $this->assertEquals('SUCCESS', $response['data']['status']);
        $this->assertEquals('TK-0000', $response['data']['message']['code']);
    }
}
