<?php declare(strict_types=1);

namespace TK\API\Endpoint;

use TK\API\Client;

abstract class EndpointAbstract
{

    protected $endpoint;
    protected $queryParameters = [];
    protected $headers = [];
    protected $httpRequestMethod = Client::HTTP_POST;
    protected $responseRoot = '';
    protected $requestHeaderRequired = true;

    public function getEndpoint() : string
    {
        return $this->endpoint;
    }

    public function getHeaders() : array
    {
        return $this->headers;
    }

    public function getQueryParams() : array
    {
        return $this->queryParameters;
    }

    public function getHttpRequestMethod() : string
    {
        return $this->httpRequestMethod;
    }

    public function getResponseRoot() : string
    {
        return $this->responseRoot;
    }

    public function doesRequireRequestHeaders() : bool
    {
        return $this->requestHeaderRequired;
    }
}
