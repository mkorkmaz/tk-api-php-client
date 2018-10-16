<?php
declare(strict_types=1);

namespace TK\SDK\Endpoint;

use TK\SDK\ValueObject\GetAvailabilityParameters;

final class GetAvailability extends EndpointAbstract implements EndpointInterface
{
    public function __construct(GetAvailabilityParameters $queryParameters)
    {
        $this->endpoint = '/getAvailability';
        $this->queryParameters = $queryParameters->getValue();
    }
}
