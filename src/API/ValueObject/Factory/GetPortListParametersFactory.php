<?php
declare(strict_types=1);

namespace TK\API\ValueObject\Factory;

use TK\API\Exception\InvalidArgumentException;
use TK\API\ValueObject\GetPortListParameters;

final class GetPortListParametersFactory implements ValueObjectFactoryInterface
{
    /**
     * @param array $parameters
     * @return GetPortListParameters
     * @throws \Exception
     */
    public static function createFromArray(array $parameters) : GetPortListParameters
    {
        $getPortListParameters = new GetPortListParameters($parameters['airlineCode']);
        if (array_key_exists('languageCode', $parameters)) {
            $getPortListParameters = $getPortListParameters->withLanguageCode($parameters['languageCode']);
        }
        return$getPortListParameters;
    }


    /**
     * @param string $json
     * @return GetPortListParameters
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public static function createFromJson(string $json) : GetPortListParameters
    {
        $parameters = json_decode($json, (bool) JSON_OBJECT_AS_ARRAY);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(
                'GetPortListParametersFactory Error: ' . json_last_error_msg()
            );
        }
        return self::createFromArray($parameters);
    }
}
