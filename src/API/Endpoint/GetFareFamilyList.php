<?php
declare(strict_types=1);

namespace TK\API\Endpoint;

use TK\API\ValueObject\GetFareFamilyListParameters;

final class GetFareFamilyList extends EndpointAbstract implements EndpointInterface
{
    public function __construct(GetFareFamilyListParameters $queryParameters)
    {
        $this->endpoint = '/getFareFamilyList';
        $this->responseRoot = 'fareFamilyOTAResponse';
        $this->queryParameters = $queryParameters->getValue();
    }
}
