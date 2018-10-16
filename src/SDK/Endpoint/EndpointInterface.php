<?php
declare(strict_types=1);

namespace TK\SDK\Endpoint;

interface EndpointInterface
{
    public function getEndpoint();
    public function getHeaders();
    public function getQueryParams();
    public function getHttpRequestMethod();
}
