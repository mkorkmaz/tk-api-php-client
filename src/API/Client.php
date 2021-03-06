<?php declare(strict_types=1);

/**
 * @package TK\API
 * @author Mehmet Korkmaz <mehmet@mkorkmaz.com>
 * @license https://opensource.org/licenses/mit-license.php MIT
 *
 * Documentation can be found at https://developer.turkishairlines.com/documentation/
 */

namespace TK\API;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use TK\API\Endpoint\EndpointInterface;
use TK\API\Exception\InvalidArgumentException;
use TK\API\Exception\BadMethodCallException;
use TK\API\Exception\RequestException;
use TypeError;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use Ulid\Ulid;

final class Client
{
    public const HTTP_POST = 'POST';
    public const HTTP_GET = 'GET';
    /**
     * @var array
     */
    private static $validEndpoints = [

        'getAvailability',
        'getTimetable',
        'getPortList',
        'rejectActions',
        'getFareFamilyList',
        'retrieveReservationDetail',
        'calculateFlightMiles',
        'calculateAwardMilesWithTax'
    ];


    /**
     * @var Environment
     */
    private $environment;
    /**
     * @var GuzzleClient
     */
    private $guzzleClient;

    private $logger;
    private $languageCode;
    private $airlineCode;


    private $headers = [
        'User-Agent' => 'mkorkmaz/tk-api-php-client 2.0'
    ];

    /**
     * Client constructor.
     * @param Environment $environment
     * @param GuzzleClient $guzzleClient
     * @param LoggerInterface $logger
     */
    public function __construct(Environment $environment, GuzzleClient $guzzleClient, LoggerInterface $logger)
    {
        $this->environment = $environment;
        $this->headers['apiKey'] = $environment->getApiKey();
        $this->headers['apiSecret'] = $environment->getApiSecret();
        $this->guzzleClient = $guzzleClient;
        $this->logger = $logger;
        $this->airlineCode = 'TK';
        $this->languageCode = 'TR';
    }

    public function withAirlineCode(string $airlineCode) : self
    {
        $new = clone $this;
        $new->airlineCode = $airlineCode;
        return $new;
    }

    public function withLanguageCode(string $languageCode) : self
    {
        $new = clone $this;
        $new->languageCode = $languageCode;
        return $new;
    }
    /**
     * @param $name
     * @param $arguments
     * @throws BadMethodCallException
     * @throws RequestException
     * @throws InvalidArgumentException
     * @return array
     */
    public function __call(string $name, array $arguments)
    {
        return $this->request($this->getEndpoint($name, $arguments));
    }


    private function getEndpoint(string $name, array $arguments) : EndpointInterface
    {
        $namespace = '\\TK\\API\\Endpoint';
        $endpointClass = $namespace . '\\' . \ucfirst($name);
        if (!\in_array($name, self::$validEndpoints, true) || !class_exists($endpointClass)) {
            $message = sprintf('%s (%s) is not valid TK API endpoint.', $name, $endpointClass);
            $this->logger->error($message);
            throw new BadMethodCallException($message);
        }
        return $this->endpointFactory($endpointClass, $arguments);
    }

   

    /**
     * @param string $endpointClass
     * @param array $arguments
     * @return EndpointInterface
     * @throws BadMethodCallException
     * @throws InvalidArgumentException
     */
    private function endpointFactory(string $endpointClass, array $arguments) : EndpointInterface
    {
        try {
            return new $endpointClass($arguments[0]);
        } catch (TypeError $e) {
            $message = 'This endpoint needs arguments, no argument provided.';
            throw new InvalidArgumentException($message);
        }
    }

    private function request(EndpointInterface $endpoint) : array
    {
        $response = $this->httpRequest($endpoint);
        $responseBodyString = (string) $response->getBody();
        $responseBody = json_decode($responseBodyString, true);
        if ($responseBody['status'] === 'FAILURE') {
            $this->logger->error('TK API ERROR', $responseBody['message']);
            throw new RequestException(
                'TK API ERROR: ' .
                $responseBody['message']['code'] . ' - ' .
                $responseBody['message']['description'] . ' OriginalResponse: ' . $responseBodyString
            );
        }
        return [
            'status' => $response->getStatusCode(),
            'reason' => $response->getReasonPhrase(),
            'headers' => $response->getHeaders(),
            'requestId' => $responseBody['requestId'],
            'response' => [
                'status' => $responseBody['status'],
                'code' => $responseBody['message']['code']
            ],
            'data' => $responseBody['data'][$endpoint->getResponseRoot()]
        ];
    }

    /**
     * @param EndpointInterface $endpoint
     * @return ResponseInterface
     */
    private function httpRequest(EndpointInterface $endpoint) : ResponseInterface
    {
        $this->headers = array_merge($this->headers, $endpoint->getHeaders());
           $queryParams = $this->getQueryParams($endpoint);

        $uri = $this->environment->getApiUrl() . $endpoint->getEndpoint();
        $options = [];
        $httpRequestMethod = $endpoint->getHttpRequestMethod();
        if ($httpRequestMethod === self::HTTP_POST) {
            $this->headers['Content-Type'] = 'application/json';
            $options['json'] = $queryParams;
        }
        if ($httpRequestMethod === self::HTTP_GET) {
            $uri .= '?' . http_build_query($queryParams);
        }
        $uri .=  '?apikey='. $this->environment->getApiKey();
        $options['headers'] = $this->headers;
        $this->logger->debug(
            'API call for :' . $endpoint->getEndpoint(),
            [
                'httpRequestMethod' => $httpRequestMethod,
                'uri' => $uri,
                'headers' => $this->headers,
                'queryParams' => $queryParams
            ]
        );
        try {
            return $this->guzzleClient->{strtolower($httpRequestMethod)}($uri, $options);
        } catch (GuzzleRequestException $e) {
            $exceptionMessage = (string) $e->getResponse()
                ->getBody()
                ->getContents();
            $message = sprintf('TK API REQUEST ERROR: %s', $exceptionMessage);
            $this->logger->error($message);
            throw new RequestException($message);
        }
    }

    private function getQueryParams(EndpointInterface $endpoint) : array
    {
        $requiresRequestHeaders = $endpoint->doesRequireRequestHeaders();
        $queryParams = $endpoint->getQueryParams();
        if ($requiresRequestHeaders) {
            $queryParams['requestHeader'] = [
                'clientUsername' => $this->environment->getClientUsername(),
                'clientTransactionId' => (string) Ulid::generate(),
                'channel' => $this->environment->getChannel(),
                'languageCode' => $queryParams['languageCode'] ?? $this->languageCode,
                'airlineCode' => $queryParams['airlineCode'] ?? $this->airlineCode
            ];
            if (array_key_exists('languageCode', $queryParams)) {
                unset($queryParams['languageCode']);
            }
            if (array_key_exists('airlineCode', $queryParams)) {
                unset($queryParams['airlineCode']);
            }
        }
        return $queryParams;
    }
}
