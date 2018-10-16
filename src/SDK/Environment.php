<?php declare(strict_types=1);

namespace TK\SDK;

final class Environment
{
    private $apiUrl;
    private $apiKey;
    private $apiSecret;

    public function __construct(string $apiUrl, string $apiKey, string $apiSecret)
    {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    public function getApiUrl() :string
    {
        return $this->apiUrl;
    }

    public function getApiKey() :string
    {
        return $this->apiKey;
    }

    public function getApiSecret() : string
    {
        return $this->apiSecret;
    }
}
