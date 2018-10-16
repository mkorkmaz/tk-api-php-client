<?php
declare(strict_types=1);

namespace TK\SDK\Endpoint;

use TK\SDK\ValueObject\GetPortListParameters;

final class GetPortList extends EndpointAbstract implements EndpointInterface
{
    public function __construct(GetPortListParameters $queryParameters)
    {
        $this->endpoint = '/getPortList';
        $this->httpRequestMethod = 'GET';
        $this->queryParameters = $queryParameters->getValue();
    }
}
