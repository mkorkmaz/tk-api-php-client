<?php
declare(strict_types=1);

namespace TK\Test\Unit\Endpoint;

use TK\SDK\ValueObject;

class GetPortListTest extends EndpointAbstract
{
    /**
     * @test
     */
    public function shouldGetResponseSuccessfully() : void
    {
        $getPortListParameters = (new ValueObject\GetPortListParameters(
            ValueObject\GetPortListParameters::AIRLINE_CODE_TURKISH_AIRLINES
        ))->withLanguageCode(ValueObject\GetPortListParameters::LANGUAGE_CODE_EN);

        $response = $this->client->getPortList($getPortListParameters);
        $this->assertEquals(200, $response['status']);
        $this->assertEquals('SUCCESS', $response['response']['status']);
        $this->assertEquals('TK-0000', $response['response']['code']);
    }
}
