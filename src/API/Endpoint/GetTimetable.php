<?php
declare(strict_types=1);

namespace TK\API\Endpoint;

use TK\API\ValueObject\GetTimetableParameters;

final class GetTimetable extends EndpointAbstract implements EndpointInterface
{

    public function __construct(GetTimetableParameters $queryParameters)
    {
        $this->endpoint = '/getTimeTable';
        $this->responseRoot = 'timeTableOTAResponse';
        $this->queryParameters = $queryParameters->getValue();
    }
}
