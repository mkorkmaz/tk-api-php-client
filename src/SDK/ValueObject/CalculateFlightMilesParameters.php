<?php
declare(strict_types=1);

namespace TK\SDK\ValueObject;

use DateTimeImmutable;
use TK\SDK\Exception\InvalidArgumentException;

class CalculateFlightMilesParameters implements ValueObjectInterface
{
    private static $cardTypesEnum = ['CC', 'CP', 'EC', 'EP'];

    private $origin;
    private $destination;
    private $cabinCode;
    private $classCode;
    private $marketingClassCode;
    private $cardType;
    private $flightDate;
    private $operatingFlightNumber;
    private $marketingFlightNumber;

    public function __construct(string $origin, string $destination)
    {
        $this->origin = $this->getIataCode($origin);
        $this->destination = $this->getIataCode($destination);
    }

    private function getIataCode(string $iataCode) : string
    {
        if (!preg_match('/[A-Z]{3}/', $iataCode)) {
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

    public function withCabinCode() : CalculateFlightMilesParameters
    {
        $this->cabinCode = 'Y';
        return $this;
    }

    public function withClassCode() : CalculateFlightMilesParameters
    {
        $this->classCode = 'Y';
        return $this;
    }

    public function withMarketingClassCode(string $marketingClassCode) : CalculateFlightMilesParameters
    {
        $this->marketingClassCode = $marketingClassCode;
        return $this;
    }

    public function withCardType(string $cardType) : CalculateFlightMilesParameters
    {
        if (!\in_array($cardType, self::$cardTypesEnum, true)) {
            throw new InvalidArgumentException(
                'Invalid card_type value provided. Possile values are: ' .
                implode(', ', self::$cardTypesEnum)
            );
        }
        $this->cardType = $cardType;
        return $this;
    }

    public function withFlightDate(DateTimeImmutable $flightDate) : CalculateFlightMilesParameters
    {
        $this->flightDate = $flightDate;
        return $this;
    }

    public function withOperatingFlightNumber(string $operatingFlightNumber) : CalculateFlightMilesParameters
    {
        $this->operatingFlightNumber = $operatingFlightNumber;
        return $this;
    }

    public function withMarketingFlightNumber(string $marketingFlightNumber) : CalculateFlightMilesParameters
    {
        $this->marketingFlightNumber = $marketingFlightNumber;
        return $this;
    }

    public function getValue() : array
    {
        $calculateFlightMilesParameters = [
            'origin' => $this->origin,
            'destination' => $this->destination
        ];
        if ($this->cabinCode !== null) {
            $calculateFlightMilesParameters['cabin_code'] = 'Y';
        }
        if ($this->classCode !== null) {
            $calculateFlightMilesParameters['class_code'] = 'Y';
        }
        if ($this->marketingClassCode !== null) {
            $calculateFlightMilesParameters['marketingClassCode'] = $this->marketingClassCode;
        }
        if ($this->cardType !== null) {
            $calculateFlightMilesParameters['card_type'] = $this->cardType;
        }
        if ($this->flightDate !== null) {
            $calculateFlightMilesParameters['flightDate'] = $this->flightDate->format('d.m.Y');
        }
        if ($this->operatingFlightNumber !== null) {
            $calculateFlightMilesParameters['operatingFlightNumber'] = $this->operatingFlightNumber;
        }
        if ($this->marketingFlightNumber !== null) {
            $calculateFlightMilesParameters['marketingFlightNumber'] = $this->marketingFlightNumber;
        }

        return $calculateFlightMilesParameters;
    }
}
