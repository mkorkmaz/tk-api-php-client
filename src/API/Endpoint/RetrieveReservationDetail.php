<?php
declare(strict_types=1);

namespace TK\API\Endpoint;

use TK\API\ValueObject\RetrieveReservationDetailParameters;

final class RetrieveReservationDetail extends EndpointAbstract implements EndpointInterface
{
    public function __construct(RetrieveReservationDetailParameters $queryParameters)
    {
        $this->endpoint = '/retrieveReservationDetail';
        $this->responseRoot = 'retrieveReservationOTAResponse';
        $this->queryParameters = $queryParameters->getValue();
    }
}
