<?php
declare(strict_types=1);

namespace TK\API\Endpoint;

use TK\API\ValueObject\GetAvailabilityParameters;

final class GetAvailability extends EndpointAbstract implements EndpointInterface
{
    public function __construct(GetAvailabilityParameters $queryParameters)
    {
        $this->endpoint = '/getAvailability';
        $this->responseRoot = 'availabilityOTAResponse';
        $this->queryParameters = $queryParameters->getValue();
    }
}
