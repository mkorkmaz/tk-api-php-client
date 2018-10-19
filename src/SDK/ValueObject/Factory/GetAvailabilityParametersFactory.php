<?php
declare(strict_types=1);

namespace TK\SDK\ValueObject\Factory;

use TK\SDK\ValueObject\GetAvailabilityParameters;
use TK\SDK\ValueObject\Location;
use TK\SDK\ValueObject\DepartureDateTime;
use TK\SDK\ValueObject\OriginDestinationInformation;
use TK\SDK\ValueObject\PassengerTypeQuantity;
use DateTimeImmutable;
use TK\SDK\Exception\InvalidArgumentException;

final class GetAvailabilityParametersFactory implements ValueObjectFactoryInterface
{
    /**
     * @param array $parameters
     * @return GetAvailabilityParameters
     * @throws \Exception
     */
    public static function createFromArray(array $parameters) : GetAvailabilityParameters
    {
        $originDestinationInformations = [];
        foreach ($parameters['OriginDestinationInformation']  as $originDestinationInformation) {
            $originLocation = new Location(
                $originDestinationInformation['OriginLocation']['LocationCode'],
                $originDestinationInformation['OriginLocation']['MultiAirportCityInd']
            );
            $destinationLocation  = new Location(
                $originDestinationInformation['DestinationLocation']['LocationCode'],
                $originDestinationInformation['DestinationLocation']['MultiAirportCityInd']
            );
            $departureDateTime = (new DepartureDateTime(
                DateTimeImmutable::createFromFormat('dM', $originDestinationInformation['DepartureDateTime']['Date']),
                $originDestinationInformation['DepartureDateTime']['WindowAfter'],
                $originDestinationInformation['DepartureDateTime']['WindowBefore']
            ))->withDateFormat('dM');
            $originDestinationInformationObject = new OriginDestinationInformation(
                $departureDateTime,
                $originLocation,
                $destinationLocation
            );
            if (array_key_exists('CabinPreferences', $originDestinationInformation)) {
                foreach ($originDestinationInformation['CabinPreferences'] as $cabinPreference) {
                    $originDestinationInformationObject = $originDestinationInformationObject
                        ->withCabinPreferences($cabinPreference['Cabin']);
                }
            }
            $originDestinationInformations[] = $originDestinationInformationObject;
        }
        $passengerTypeQuantityObject =  new PassengerTypeQuantity();
        foreach ($parameters['PassengerTypeQuantity'] as $passengerTypeQuantity) {
            $passengerTypeQuantityObject->withQuantity(
                $passengerTypeQuantity['Code'],
                $passengerTypeQuantity['Quantity']
            );
        }
        $getAvailabilityParameters = new GetAvailabilityParameters(
            $parameters['ReducedDataIndicator'],
            $parameters['RoutingType'],
            $passengerTypeQuantityObject
        );

        if (array_key_exists('TargetSource', $parameters)) {
            $getAvailabilityParameters = $getAvailabilityParameters->withTargetSource();
        }
        foreach ($originDestinationInformations as $originDestinationInformationObject) {
            $getAvailabilityParameters = $getAvailabilityParameters->withOriginDestinationInformation($originDestinationInformationObject);
        }
        return $getAvailabilityParameters;
    }

    /**
     * @param string $json
     * @return GetAvailabilityParameters
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public static function createFromJson(string $json) : GetAvailabilityParameters
    {
        $parameters = json_decode($json, (bool) JSON_OBJECT_AS_ARRAY);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(
                'GetAvailabilityParametersFactory Error: ' . json_last_error_msg()
            );
        }
        return self::createFromArray($parameters);
    }
}
