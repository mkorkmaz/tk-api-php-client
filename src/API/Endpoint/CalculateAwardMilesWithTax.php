<?php
declare(strict_types=1);

namespace TK\API\Endpoint;

use TK\API\ValueObject\CalculateAwardMilesWithTaxParameters;

final class CalculateAwardMilesWithTax extends EndpointAbstract implements EndpointInterface
{
    public function __construct(CalculateAwardMilesWithTaxParameters $queryParameters)
    {
        $this->endpoint = '/calculateAwardMilesWithTax';
        $this->responseRoot = 'return';
        $this->queryParameters = $queryParameters->getValue();
    }
}
