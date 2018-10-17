<?php
declare(strict_types=1);

namespace TK\Test\Unit\Endpoint;

use TK\SDK\ValueObject;

class GetFareFamilyListTest extends EndpointAbstract
{

    /**
     * @test
     */
    public function shouldGetResponseSuccessfully() : void
    {
        $getFareFamilyListParameters = (new ValueObject\GetFareFamilyListParameters())
            ->withPortIataCode('IST')
            ->withMilesRequest();

        $response = $this->client->getFareFamilyList($getFareFamilyListParameters);
        $this->assertEquals(200, $response['status']);
        $this->assertEquals('SUCCESS', $response['response']['status']);
        $this->assertEquals('TK-0000', $response['response']['code']);
    }
}
