<?php
declare(strict_types=1);

namespace TK\API\ValueObject;

use TK\API\Exception\InvalidArgumentException;

final class OriginDestinationInformation implements ValueObjectInterface
{
    public const CABIN_PREFERENCE_ECONOMY = 'ECONOMY';
    public const CABIN_PREFERENCE_BUSINESS = 'BUSINESS';

    private static $cabinPreferencesEnum = ['ECONOMY', 'BUSINESS'];

    private $departureDateTime;
    private $originLocation;
    private $destinationLocation;
    private $cabinPreferences = [];

    public function __construct(
        DepartureDateTime $departureDateTime,
        Location $originLocation,
        Location $destinationLocation
    ) {
        $this->departureDateTime = $departureDateTime;
        $this->originLocation = $originLocation;
        $this->destinationLocation = $destinationLocation;
    }

    public function withCabinPreferences(string $cabinPreference) : OriginDestinationInformation
    {
        if (!\in_array($cabinPreference, self::$cabinPreferencesEnum, true)) {
            throw new InvalidArgumentException(
                'Invalid value for OriginDestinationInformation.CabinPreferences. Use one of these: ' .
                implode(', ', self::$cabinPreferencesEnum)
            );
        }
        $this->cabinPreferences[] = $cabinPreference;
        return $this;
    }

    public function getValue() : array
    {
        $originDestinationInformationValue = [
            'DepartureDateTime' => $this->departureDateTime->getValue(),
            'OriginLocation' => $this->originLocation->getValue(),
            'DestinationLocation' => $this->destinationLocation->getValue()
        ];
        if (\count($this->cabinPreferences) !== 0) {
            $originDestinationInformationValue['CabinPreferences'] = [];
            foreach ($this->cabinPreferences as $cabinPreference) {
                $originDestinationInformationValue['CabinPreferences'][] = ['Cabin' => $cabinPreference];
            }
        }
        return $originDestinationInformationValue;
    }
}
