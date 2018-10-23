<?php
declare(strict_types=1);

namespace TK\SDK\ValueObject\Factory;

use DateTimeImmutable;
use TK\SDK\Exception\InvalidArgumentException;
use TK\SDK\ValueObject\CalculateFlightMilesParameters;

class CalculateFlightMilesParametersFactory implements ValueObjectFactoryInterface
{
    /**
     * @param array $parameters
     * @return CalculateFlightMilesParameters
     * @throws \Exception
     */
    public static function createFromArray(array $parameters) : CalculateFlightMilesParameters
    {
        $calculateFlightMilesParameters = new CalculateFlightMilesParameters(
            $parameters['origin'],
            $parameters['destination']
        );
        if (array_key_exists('cabin_code', $parameters) && $parameters['cabin_code'] === 'Y') {
            $calculateFlightMilesParameters = $calculateFlightMilesParameters->withCabinCode();
        }
        if (array_key_exists('class_code', $parameters) && $parameters['class_code'] === 'Y') {
            $calculateFlightMilesParameters = $calculateFlightMilesParameters->withClassCode();
        }
        if (array_key_exists('marketingClassCode', $parameters)) {
            $calculateFlightMilesParameters = $calculateFlightMilesParameters
                ->withMarketingClassCode($parameters['marketingClassCode']);
        }
        if (array_key_exists('card_type', $parameters)) {
            $calculateFlightMilesParameters = $calculateFlightMilesParameters
                ->withCardType($parameters['card_type']);
        }
        if (array_key_exists('flightDate', $parameters)) {
            $calculateFlightMilesParameters = $calculateFlightMilesParameters
                ->withFlightDate(DateTimeImmutable::createFromFormat('d.m.Y', $parameters['flightDate']));
        }
        if (array_key_exists('operatingFlightNumber', $parameters)) {
            $calculateFlightMilesParameters = $calculateFlightMilesParameters
                ->withOperatingFlightNumber($parameters['operatingFlightNumber']);
        }
        if (array_key_exists('marketingFlightNumber', $parameters)) {
            $calculateFlightMilesParameters = $calculateFlightMilesParameters
                ->withMarketingFlightNumber($parameters['marketingFlightNumber']);
        }
        return $calculateFlightMilesParameters;
    }


    /**
     * @param string $json
     * @return CalculateFlightMilesParameters
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public static function createFromJson(string $json) : CalculateFlightMilesParameters
    {
        $parameters = json_decode($json, (bool) JSON_OBJECT_AS_ARRAY);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(
                'CalculateFlightMilesParametersFactory Error: ' . json_last_error_msg()
            );
        }
        return self::createFromArray($parameters);
    }
}
