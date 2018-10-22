<?php
declare(strict_types=1);

namespace TK\SDK\Endpoint;

use TK\SDK\ValueObject\CalculateFlightMilesParameters;

final class CalculateFlightMiles extends EndpointAbstract implements EndpointInterface
{
    public function __construct(CalculateFlightMilesParameters $queryParameters)
    {
        $this->endpoint = '/calculateFlightMiles';
        $this->responseRoot = 'milesResponseDetail';
        $this->queryParameters = $queryParameters->getValue();
    }
}
