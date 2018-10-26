<?php
declare(strict_types=1);

namespace TK\Test\Unit\Resources;

use TK\SDK\Endpoint\EndpointAbstract;
use TK\SDK\Endpoint\EndpointInterface;

class ExampleEndpoint extends EndpointAbstract implements EndpointInterface
{
    public function __construct()
    {
        $this->endpoint = '/nonExistedEndpoint';
        $this->responseRoot = 'none';
        $this->queryParameters = [];
    }
}
