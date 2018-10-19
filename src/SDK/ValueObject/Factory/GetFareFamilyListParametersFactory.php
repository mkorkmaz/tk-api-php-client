<?php
declare(strict_types=1);

namespace TK\SDK\ValueObject\Factory;

use TK\SDK\Exception\InvalidArgumentException;
use TK\SDK\ValueObject\GetFareFamilyListParameters;

class GetFareFamilyListParametersFactory implements ValueObjectFactoryInterface
{
    /**
     * @param array $parameters
     * @return GetFareFamilyListParameters
     * @throws \Exception
     */
    public static function createFromArray(array $parameters) : GetFareFamilyListParameters
    {
        $getFareFamilyListParameters = new GetFareFamilyListParameters();
        foreach ($parameters['portList'] as $airportIataCode) {
            $getFareFamilyListParameters->withAirportIataCode($airportIataCode);
        }
        if (array_key_exists('isMilesRequest', $parameters) && $parameters['isMilesRequest'] === 'T') {
            $getFareFamilyListParameters->withMilesRequest();
        }
        return  $getFareFamilyListParameters;
    }


    /**
     * @param string $json
     * @return GetFareFamilyListParameters
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public static function createFromJson(string $json) : GetFareFamilyListParameters
    {
        $parameters = json_decode($json, (bool) JSON_OBJECT_AS_ARRAY);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(
                'GetFareFamilyListParametersFactory Error: ' . json_last_error_msg()
            );
        }
        return self::createFromArray($parameters);
    }
}
