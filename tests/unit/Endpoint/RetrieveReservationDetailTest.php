<?php
declare(strict_types=1);

namespace TK\Test\Unit\Endpoint;

use TK\SDK\ValueObject\RetrieveReservationDetailParameters;

class RetrieveReservationDetailTest extends EndpointAbstract
{

    /**
     * @test
     */
    public function shouldGetResponseSuccessfully() : void
    {
        $retrieveReservationDetailParameters = new RetrieveReservationDetailParameters(
            'TT8VN8',
            'CELIKTAS'
        );

        $response = $this->client->retrieveReservationDetail($retrieveReservationDetailParameters);
        $this->assertEquals(200, $response['status']);
        $this->assertEquals('SUCCESS', $response['response']['status']);
        $this->assertEquals('TK-0000', $response['response']['code']);
    }
}
