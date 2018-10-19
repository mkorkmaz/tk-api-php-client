<?php
declare(strict_types=1);

namespace TK\SDK\ValueObject\Factory;

use DateTimeImmutable;
use TK\SDK\ValueObject\Location;
use TK\SDK\ValueObject\DepartureDateTime;
use TK\SDK\ValueObject\OriginDestinationInformation;
use TK\SDK\ValueObject\AirScheduleRQ;
use TK\SDK\ValueObject\GetTimetableParameters;
use TK\SDK\Exception\InvalidArgumentException;

final class GetTimetableParametersFactory implements ValueObjectFactoryInterface
{
    /**
     * @param array $parameters
     * @return GetTimetableParameters
     * @throws \Exception
     */
    public static function createFromArray(array $parameters) : GetTimetableParameters
    {
        $originDestinationInformation = $parameters['OTA_AirScheduleRQ']['OriginDestinationInformation'];
        $originLocation = new Location(
            $originDestinationInformation['OriginLocation']['LocationCode'],
            $originDestinationInformation['OriginLocation']['MultiAirportCityInd']
        );
        $destinationLocation = new Location(
            $originDestinationInformation['DestinationLocation']['LocationCode'],
            $originDestinationInformation['DestinationLocation']['MultiAirportCityInd']
        );
        $departureDateTime = new DepartureDateTime(
            DateTimeImmutable::createFromFormat('Y-m-d', $originDestinationInformation['DepartureDateTime']['Date']),
            'P3D',
            'P3D'
        );
        $originDestinationInformationObject = new OriginDestinationInformation(
            $departureDateTime,
            $originLocation,
            $destinationLocation
        );
        $airScheduleRQ = new AirScheduleRQ($originDestinationInformationObject);
        if (array_key_exists('AirlineCode', $parameters['OTA_AirScheduleRQ'])) {
            $airScheduleRQ = $airScheduleRQ->withAirlineCode($parameters['OTA_AirScheduleRQ']['AirlineCode']);
        }
        if (array_key_exists('FlightTypePref', $parameters['OTA_AirScheduleRQ']) &&
            $parameters['OTA_AirScheduleRQ']['FlightTypePref']['DirectAndNonStopOnlyInd'] === true) {
            $airScheduleRQ = $airScheduleRQ->withDirectAndNonStopOnlyInd();
        }
        $getTimetableParameters =  new GetTimetableParameters(
            $airScheduleRQ,
            $parameters['scheduleType'],
            $parameters['tripType']
        );
        if (array_key_exists('returnDate', $parameters)) {
            $returnDate = DateTimeImmutable::createFromFormat('Y-m-d', $parameters['returnDate']);
            $getTimetableParameters = $getTimetableParameters->withReturnDate($returnDate);
        }
        return $getTimetableParameters;
    }

    /**
     * @param string $json
     * @return GetTimetableParameters
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public static function createFromJson(string $json) : GetTimetableParameters
    {
        $parameters = json_decode($json, (bool) JSON_OBJECT_AS_ARRAY);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(
                'GetTimetableParametersFactory Error: ' . json_last_error_msg()
            );
        }
        return self::createFromArray($parameters);
    }
}
