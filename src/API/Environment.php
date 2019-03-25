<?php declare(strict_types=1);

namespace TK\API;

final class Environment
{
    private $apiUrl;
    private $apiKey;
    private $apiSecret;
    private $clientUsername;
    private $channel;
    private $appName;

    public function __construct(
        string $apiUrl,
        string $apiKey,
        string $apiSecret,
        ?string $clientUsername = null,
        ?string $appName = null,
        ?string $channel = 'WEB'
    ) {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->clientUsername = $clientUsername;
        $this->channel = $channel;
        $this->appName = $appName;
    }

    public static function createWithUserName (
        string $apiUrl,
        string $apiKey,
        string $apiSecret,
        ?string $clientUsername = null,
        ?string $channel = null
    ) :self {
        return new self($apiUrl, $apiKey, $apiSecret, $clientUsername, null, $channel);
    }
    public static function createWithAppName (
        string $apiUrl,
        string $apiKey,
        string $apiSecret,
        ?string $appName = null,
        ?string $channel = null
    ) :self {
        return new self($apiUrl, $apiKey, $apiSecret, null, $appName, $channel);
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

    public function getClientUsername() : string
    {
        return $this->clientUsername;
    }

    public function  getChannel() : string
    {
        return $this->channel ?? 'WEB';
    }
    public function  getAppName() : string
    {
        return $this->appName;
    }
}
