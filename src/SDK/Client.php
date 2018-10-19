<?php declare(strict_types=1);

/**
 * @package TK\SDK
 * @author Mehmet Korkmaz <mehmet@mkorkmaz.com>
 * @license https://opensource.org/licenses/mit-license.php MIT
 *
 * Documentation can be found at https://developer.turkishairlines.com/documentation/
 */

namespace TK\SDK;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use TK\SDK\Endpoint\EndpointInterface;
use TK\SDK\Exception\InvalidArgumentException;
use TK\SDK\Exception\BadMethodCallException;
use TK\SDK\Exception\RequestException;
use TypeError;
use Exception;

final class Client
{

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
     * @var string
     */
    private $apiUrl;
    /**
     * @var GuzzleClient
     */
    private $guzzleClient;

    private $logger;

    private $headers = [
        'User-Agent' => 'mkorkmaz/tk-api-php-sdk 1.0'
    ];

    /**
     * Client constructor.
     * @param Environment $environment
     * @param GuzzleClient $guzzleClient
     * @param LoggerInterface $logger
     */
    public function __construct(Environment $environment, GuzzleClient $guzzleClient, LoggerInterface $logger)
    {
        $this->apiUrl = $environment->getApiUrl();
        $this->headers['apiKey'] = $environment->getApiKey();
        $this->headers['apiSecret'] = $environment->getApiSecret();
        $this->guzzleClient = $guzzleClient;
        $this->logger = $logger;
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
        $namespace = '\\TK\\SDK\\Endpoint';
        $endpointClass =  $namespace . '\\'. \ucfirst($name);
        if (!\in_array($name, self::$validEndpoints, true) || ! class_exists($endpointClass)) {
            $message = sprintf('%s (%s) is not valid TK API endpoint.', $name, $endpointClass);
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
        $endpointObject = new $endpointClass($arguments[0]);
        try {
            return $endpointObject;
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
            throw new RequestException(
                'API ERROR: ' .
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
            'data' => $responseBody['data']
        ];
    }

    /**
     * @param EndpointInterface $endpoint
     * @return ResponseInterface
     */
    private function httpRequest(EndpointInterface $endpoint) : ResponseInterface
    {
        $this->headers = array_merge($this->headers, $endpoint->getHeaders());
        $uri = $this->apiUrl . $endpoint->getEndpoint();
        $options = [];
        $httpRequestMethod = strtolower($endpoint->getHttpRequestMethod());
        if ($httpRequestMethod === 'post') {
            $this->headers['Content-Type'] = 'application/json';
            $options['json'] = $endpoint->getQueryParams();
        }
        if ($httpRequestMethod === 'get') {
            $uri .= '?' . http_build_query($endpoint->getQueryParams());
        }
        $options['headers'] = $this->headers;
        try {
            return $this->guzzleClient->{$httpRequestMethod}($uri, $options);
        } catch (Exception $e) {
            $exceptionMessage = (string) $e->getResponse()->getBody()->getContents();
            $message = sprintf('TK API Request Error: %s', $exceptionMessage);
            throw new RequestException($message);
        }
    }
}
