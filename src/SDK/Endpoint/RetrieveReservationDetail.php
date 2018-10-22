<?php
declare(strict_types=1);

namespace TK\SDK\Endpoint;

use TK\SDK\ValueObject\RetrieveReservationDetailParameters;

final class RetrieveReservationDetail extends EndpointAbstract implements EndpointInterface
{
    public function __construct(RetrieveReservationDetailParameters $queryParameters)
    {
        $this->endpoint = '/retrieveReservationDetail';
        $this->responseRoot = 'retrieveReservationOTAResponse';
        $this->httpRequestMethod = 'get';
        $this->queryParameters = $queryParameters->getValue();
    }
}
