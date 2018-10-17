<?php
declare(strict_types=1);

namespace TK\Test\Unit\Endpoint;

use DateTimeImmutable;
use TK\SDK\ValueObject;

class CalculateAwardMilesWithTaxTest extends EndpointAbstract
{
    /**
     * @test
     */
    public function shouldGetResponseSuccessfully() : void
    {
        $departureDate = gmdate('Y-m-d H:i:s', strtotime('-4 days'));
        $calculateAwardMilesWithTaxParameters = (new ValueObject\CalculateAwardMilesWithTaxParameters(
            'E'
        ))->withOneWay()
            ->withSeatGuaranteed()
            ->withDepartureOrigin('IST')
            ->withDepartureDestination('JFK')
            ->withDepartureDate(new DateTimeImmutable($departureDate));
        $response = $this->client->calculateAwardMilesWithTax($calculateAwardMilesWithTaxParameters);
        $this->assertEquals(200, $response['status']);
        $this->assertEquals('SUCCESS', $response['response']['status']);
        $this->assertEquals('TK-0000', $response['response']['code']);
    }
}
