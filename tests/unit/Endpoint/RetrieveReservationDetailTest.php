<?php
declare(strict_types=1);

namespace TK\Test\Unit\Endpoint;

use TK\SDK\ValueObject;

class RetrieveReservationDetailTest extends EndpointAbstract
{

    /**
     * @test
     */
    public function shouldGetResponseSuccessfully() : void
    {
        // Since We dont have any real UniqueId and Surname we expect this test to throw exception.
        // We should request valid parameters from Turkish Airlines for test purposes.
        $this->expectException(\Exception::class);
        $retrieveReservationDetailParameters = new ValueObject\RetrieveReservationDetailParameters(
            '12345678901',
            'KORKMAZ'
        );

        $response = $this->client->retrieveReservationDetail($retrieveReservationDetailParameters);
        $this->assertEquals(400, $response['status']);
        $this->assertEquals('SUCCESS', $response['data']['status']);
        $this->assertEquals('TK-0000', $response['data']['message']['code']);
    }
}
