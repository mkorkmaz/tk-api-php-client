<?php
declare(strict_types=1);

namespace TK\SDK;

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
        string $apiSecret
    ) {
        $this->environment = new Environment($apiUrl, $apiKey, $apiSecret);
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
        $log = new Logger('SDK-API');
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
