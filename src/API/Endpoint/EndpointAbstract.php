<?php declare(strict_types=1);

namespace TK\API\Endpoint;

abstract class EndpointAbstract
{
    protected $endpoint;
    protected $queryParameters = [];
    protected $headers = [];
    protected $httpRequestMethod = 'POST';
    protected $responseRoot = '';

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
}
