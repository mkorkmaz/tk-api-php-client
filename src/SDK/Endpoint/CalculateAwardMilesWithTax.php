<?php
declare(strict_types=1);

namespace TK\SDK\Endpoint;

use TK\SDK\ValueObject\CalculateAwardMilesWithTaxParameters;

final class CalculateAwardMilesWithTax extends EndpointAbstract implements EndpointInterface
{
    public function __construct(CalculateAwardMilesWithTaxParameters $queryParameters)
    {
        $this->endpoint = '/calculateAwardMilesWithTax';
        $this->queryParameters = $queryParameters->getValue();
    }
}
