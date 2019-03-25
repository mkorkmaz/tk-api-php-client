<?php
declare(strict_types=1);

namespace TK\API\Endpoint;

use TK\API\ValueObject\GetPortListParameters;

final class GetPortList extends EndpointAbstract implements EndpointInterface
{
    public function __construct(GetPortListParameters $queryParameters)
    {
        $this->endpoint = '/getPortList';
        $this->responseRoot = 'Port';
        $this->queryParameters = $queryParameters->getValue();
    }
}
