<?php
declare(strict_types=1);

namespace TK\API\Endpoint;

interface EndpointInterface
{
    public function getEndpoint() : string;
    public function getHeaders() : array;
    public function getQueryParams() : array;
    public function getHttpRequestMethod() : string;
    public function getResponseRoot() : string;
    public function doesRequireRequestHeaders() : bool;
}
