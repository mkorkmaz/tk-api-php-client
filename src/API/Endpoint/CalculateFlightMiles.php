<?php
declare(strict_types=1);

namespace TK\API\Endpoint;

use TK\API\ValueObject\CalculateFlightMilesParameters;

final class CalculateFlightMiles extends EndpointAbstract implements EndpointInterface
{
    public function __construct(CalculateFlightMilesParameters $queryParameters)
    {
        $this->endpoint = '/calculateFlightMiles';
        $this->responseRoot = 'milesResponseDetail';
        $this->queryParameters = $queryParameters->getValue();
        $this->requestHeaderRequired = false;
    }
}
