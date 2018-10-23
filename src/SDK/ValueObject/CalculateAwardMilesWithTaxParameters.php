<?php
declare(strict_types=1);

namespace TK\SDK\ValueObject;

use DateTimeImmutable;
use TK\SDK\Exception\InvalidArgumentException;

class CalculateAwardMilesWithTaxParameters implements ValueObjectInterface
{
    public const AWARD_TYPE_ECONOMY = 'E';
    public const AWARD_TYPE_BUSINESS = 'B';
    public const AWARD_TYPE_FIRST_CLASS = 'C';

    private static $awardTypeEnum = ['E', 'B', 'C'];

    private $awardType;
    private $wantMoreMiles;
    private $isOneWay = 'F';
    private $departureOrigin;
    private $departureDestination;
    private $departureDate;
    private $arrivalOrigin;
    private $arrivalDestination;
    private $arrivalDate;
    private $ptcType;

    public function __construct(string $awardType)
    {
        if (!\in_array($awardType, self::$awardTypeEnum, true)) {
            throw new InvalidArgumentException(
                'Invalid awardType value. Possible values are "' .
                implode(', ', self::$awardTypeEnum) . '"' .
                ' but provided value is "' . $awardType . '"'
            );
        }
        $this->awardType = $awardType;
    }

    public function withDepartureOrigin(string $iataCode) : CalculateAwardMilesWithTaxParameters
    {
        $this->departureOrigin = $this->getIataCode($iataCode);
        return $this;
    }

    public function withDepartureDate(DateTimeImmutable $date) : CalculateAwardMilesWithTaxParameters
    {
        $this->departureDate = $date;
        return $this;
    }

    public function withDepartureDestination(string $iataCode) : CalculateAwardMilesWithTaxParameters
    {
        $this->departureDestination = $this->getIataCode($iataCode);
        return $this;
    }

    public function withArrivalOrigin(string $iataCode) : CalculateAwardMilesWithTaxParameters
    {
        $this->arrivalOrigin = $this->getIataCode($iataCode);
        return $this;
    }

    public function withArrivalDate(DateTimeImmutable $date) : CalculateAwardMilesWithTaxParameters
    {
        $this->arrivalDate = $date;
        return $this;
    }

    public function withArrivalDestination(string $iataCode) : CalculateAwardMilesWithTaxParameters
    {
        $this->arrivalDestination = $this->getIataCode($iataCode);
        return $this;
    }

    public function withPassengerType(string $passengerType) : CalculateAwardMilesWithTaxParameters
    {
        $this->ptcType = $passengerType;
        return $this;
    }

    public function withOneWay() : CalculateAwardMilesWithTaxParameters
    {
        $this->isOneWay = 'T';
        return $this;
    }

    public function withSeatGuaranteed() : CalculateAwardMilesWithTaxParameters
    {
        $this->wantMoreMiles = 'T';
        return $this;
    }

    private function getIataCode(string $iataCode) : string
    {
        if (!preg_match('/^[A-Z]{3}$/', $iataCode)) {
            {
                throw new InvalidArgumentException(
                    sprintf(
                        'Invalid OriginLocation.LocationCode value (%s) provided. Valid IATA code must be used',
                        $iataCode
                    )
                );
            }
        }
        return $iataCode;
    }

    public function getValue() : array
    {
        $calculateAwardMilesWithTaxParameters = [
            'awardType' => $this->awardType
        ];
        if ($this->wantMoreMiles !== null) {
            $calculateAwardMilesWithTaxParameters['wantMoreMiles'] = 'T';
        }
        if ($this->isOneWay !== null) {
            $calculateAwardMilesWithTaxParameters['isOneWay'] = 'T';
        }
        if ($this->departureOrigin !== null) {
            $calculateAwardMilesWithTaxParameters['departureOrigin'] = $this->departureOrigin;
        }
        if ($this->departureDestination !== null) {
            $calculateAwardMilesWithTaxParameters['departureDestination'] = $this->departureDestination;
        }
        if ($this->departureDate !== null) {
            $calculateAwardMilesWithTaxParameters['departureDateDay'] = (int) $this->departureDate->format('j');
            $calculateAwardMilesWithTaxParameters['departureDateMonth'] = (int) $this->departureDate->format('n');
            $calculateAwardMilesWithTaxParameters['departureDateYear'] = (int) $this->departureDate->format('Y');
        }
        if ($this->arrivalOrigin !== null) {
            $calculateAwardMilesWithTaxParameters['arrivalOrigin'] = $this->arrivalOrigin;
        }
        if ($this->arrivalDestination !== null) {
            $calculateAwardMilesWithTaxParameters['arrivalDestination'] = $this->arrivalDestination;
        }
        if ($this->arrivalDate !== null) {
            $calculateAwardMilesWithTaxParameters['arrivalDateDay'] = (int) $this->arrivalDate->format('j');
            $calculateAwardMilesWithTaxParameters['arrivalDateMonth'] = (int) $this->arrivalDate->format('n');
            $calculateAwardMilesWithTaxParameters['arrivalDateYear'] = (int) $this->arrivalDate->format('Y');
        }
        if ($this->ptcType !== null) {
            $calculateAwardMilesWithTaxParameters['ptcType'] = $this->ptcType;
        }
        return $calculateAwardMilesWithTaxParameters;
    }
}
