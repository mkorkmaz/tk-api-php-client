<?php
declare(strict_types=1);

namespace TK\Test\Unit\Endpoint;

use DateTimeImmutable;
use TK\API\Exception\InvalidArgumentException;
use TK\API\ValueObject\CalculateAwardMilesWithTaxParameters;

class CalculateAwardMilesWithTaxTest extends EndpointAbstract
{
    /**
     * @test
     */
    public function shouldGetResponseSuccessfully() : void
    {
        $calculateAwardMilesWithTaxParameters = (new CalculateAwardMilesWithTaxParameters(
            CalculateAwardMilesWithTaxParameters::AWARD_TYPE_ECONOMY
        ))->withOneWay()
            ->withSeatGuaranteed()
            ->withDepartureOrigin('FRA')
            ->withDepartureDestination('IST')
            ->withDepartureDate(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2017-04-21 00:00:00'));

        $response = $this->client->calculateAwardMilesWithTax($calculateAwardMilesWithTaxParameters);
        $this->assertEquals(200, $response['status']);
        $this->assertEquals('SUCCESS', $response['response']['status']);
        $this->assertEquals('TK-0000', $response['response']['code']);
    }

    /**
     * @test
     */
    public function shouldGetResponseSuccessfullyForDifferentInputs() : void
    {
        $calculateAwardMilesWithTaxParameters = (new CalculateAwardMilesWithTaxParameters(
            CalculateAwardMilesWithTaxParameters::AWARD_TYPE_ECONOMY
        ))->withOneWay()
            ->withSeatGuaranteed()
            //->withPassengerType('ADT')
            ->withArrivalOrigin('FRA')
            ->withArrivalDestination('IST')
            ->withArrivalDate(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2017-04-23 00:00:00'));

        $response = $this->client->calculateAwardMilesWithTax($calculateAwardMilesWithTaxParameters);
        $this->assertEquals(200, $response['status']);
        $this->assertEquals('SUCCESS', $response['response']['status']);
        $this->assertEquals('TK-0000', $response['response']['code']);
    }
}
