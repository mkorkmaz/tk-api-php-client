<?php
declare(strict_types=1);

namespace TK\API;

use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\ErrorLogHandler;
use GuzzleHttp;

final class ClientBuilder
{
    private $environment;
    private $logger;

    public static function create()
    {
        return new static();
    }

    public function setEnvironment(
        string $apiUrl,
        string $apiKey,
        string $apiSecret,
        ?string $clientUsername = null,
        ?string $appName = null,
        ?string $channel = null
    ) {
        $this->environment = new Environment($apiUrl, $apiKey, $apiSecret, $clientUsername, $appName, $channel);
        return $this;
    }

    public function setLogger($logger = null)
    {
        if ($logger instanceof LoggerInterface) {
            $this->logger = $logger;
            return $this;
        }
        $this->logger = $this->getLogger();
        return $this;
    }

    private function getLogger() : Logger
    {
        $log = new Logger('API-API');
        $log->pushHandler(new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM, Logger::DEBUG));
        return $log;
    }

    public function build() : Client
    {
        if ($this->logger === null) {
            $this->logger = $this->getLogger();
        }
        return new Client($this->environment, new GuzzleHttp\Client(), $this->logger);
    }
}
