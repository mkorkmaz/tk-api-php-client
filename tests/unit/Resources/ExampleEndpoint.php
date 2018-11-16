<?php
declare(strict_types=1);

namespace TK\Test\Unit\Resources;

use TK\API\Endpoint\EndpointAbstract;
use TK\API\Endpoint\EndpointInterface;

class ExampleEndpoint extends EndpointAbstract implements EndpointInterface
{
    public function __construct()
    {
        $this->endpoint = '/nonExistedEndpoint';
        $this->responseRoot = 'none';
        $this->queryParameters = [];
    }
}
