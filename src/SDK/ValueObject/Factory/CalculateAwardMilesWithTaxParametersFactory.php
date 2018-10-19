<?php
declare(strict_types=1);

namespace TK\SDK\ValueObject\Factory;

use DateTimeImmutable;
use TK\SDK\Exception\InvalidArgumentException;
use TK\SDK\ValueObject\CalculateAwardMilesWithTaxParameters;

class CalculateAwardMilesWithTaxParametersFactory implements ValueObjectFactoryInterface
{
    /**
     * @param array $parameters
     * @return CalculateAwardMilesWithTaxParameters
     * @throws \Exception
     */
    public static function createFromArray(array $parameters) : CalculateAwardMilesWithTaxParameters
    {
        $calculateAwardMilesWithTaxParameters = new CalculateAwardMilesWithTaxParameters(
            $parameters['awardType']
        );
        if (array_key_exists('wantMoreMiles', $parameters) && $parameters['wantMoreMiles'] === 'T') {
            $calculateAwardMilesWithTaxParameters = $calculateAwardMilesWithTaxParameters->withSeatGuaranteed();
        }
        if (array_key_exists('isOneWay', $parameters) && $parameters['isOneWay'] === 'T') {
            $calculateAwardMilesWithTaxParameters = $calculateAwardMilesWithTaxParameters->withOneWay();
        }
        if (array_key_exists('departureOrigin', $parameters)) {
            $calculateAwardMilesWithTaxParameters = $calculateAwardMilesWithTaxParameters
                ->withDepartureOrigin($parameters['departureOrigin']);
        }
        if (array_key_exists('departureDestination', $parameters)) {
            $calculateAwardMilesWithTaxParameters = $calculateAwardMilesWithTaxParameters
                ->withDepartureDestination($parameters['departureDestination']);
        }

        if (array_key_exists('departureDateDay', $parameters) &&
            array_key_exists('departureDateMonth', $parameters) &&
            array_key_exists('departureDateYear', $parameters)
        ) {
            $departureDate = $parameters['departureDateYear'] . '-' . $parameters['departureDateMonth'] .
                '-' . $parameters['departureDateDay'];
            $calculateAwardMilesWithTaxParameters = $calculateAwardMilesWithTaxParameters
                ->withDepartureDate(DateTimeImmutable::createFromFormat('Y-m-d', $departureDate));
        }

        if (array_key_exists('arrivalOrigin', $parameters)) {
            $calculateAwardMilesWithTaxParameters = $calculateAwardMilesWithTaxParameters
                ->withArrivalOrigin($parameters['arrivalOrigin']);
        }
        if (array_key_exists('arrivalDestination', $parameters)) {
            $calculateAwardMilesWithTaxParameters = $calculateAwardMilesWithTaxParameters
                ->withArrivalDestination($parameters['arrivalDestination']);
        }

        if (array_key_exists('arrivalDateDay', $parameters) &&
            array_key_exists('arrivalDateMonth', $parameters) &&
            array_key_exists('arrivalDateYear', $parameters)
        ) {
            $departureDate = $parameters['arrivalDateYear'] . '-' . $parameters['arrivalDateMonth'] .
                '-' . $parameters['arrivalDateDay'];
            $calculateAwardMilesWithTaxParameters = $calculateAwardMilesWithTaxParameters
                ->withDepartureDate(DateTimeImmutable::createFromFormat('Y-m-d', $departureDate));
        }
        if (array_key_exists('ptcType', $parameters)) {
            $calculateAwardMilesWithTaxParameters = $calculateAwardMilesWithTaxParameters
                ->withPassengerType($parameters['ptcType']);
        }
        return $calculateAwardMilesWithTaxParameters;
    }

    /**
     * @param string $json
     * @return CalculateAwardMilesWithTaxParameters
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public static function createFromJson(string $json) : CalculateAwardMilesWithTaxParameters
    {
        $parameters = json_decode($json, (bool) JSON_OBJECT_AS_ARRAY);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(
                'CalculateAwardMilesWithTaxParametersFactory Error: ' . json_last_error_msg()
            );
        }
        return self::createFromArray($parameters);
    }
}
