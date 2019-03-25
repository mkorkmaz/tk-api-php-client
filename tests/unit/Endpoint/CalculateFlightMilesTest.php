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
        $calculateFlightMilesParameters = (new ValueObject\CalculateFlightMilesParameters(
            'FRA',
            'IST'
        ))->withCabinCode()
        ->withCardType('CC')
        ->withOperatingFlightNumber('TK1000')
        ->withFlightDate(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2017-04-21 00:00:01'));
        $response = $this->client
            ->calculateFlightMiles($calculateFlightMilesParameters);
        $this->assertEquals(200, $response['status']);
        $this->assertEquals('SUCCESS', $response['response']['status']);
        $this->assertEquals('TK-0000', $response['response']['code']);
    }
}
