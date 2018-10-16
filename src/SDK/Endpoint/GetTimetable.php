<?php
declare(strict_types=1);

namespace TK\SDK\Endpoint;

use TK\SDK\ValueObject\GetTimetableParameters;

final class GetTimetable extends EndpointAbstract implements EndpointInterface
{
    public function __construct(GetTimetableParameters $queryParameters)
    {
        $this->endpoint = '/getTimeTable';
        $this->queryParameters = $queryParameters->getValue();
    }
}
