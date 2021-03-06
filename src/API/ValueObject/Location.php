<?php
declare(strict_types=1);

namespace TK\API\ValueObject;

use TK\API\Exception\InvalidArgumentException;

final class Location implements ValueObjectInterface
{
    public const MULTIPLE_AIRPORT_TRUE = true;
    public const MULTIPLE_AIRPORT_FALSE = false;

    private $locationCode;
    private $multiAirportCityInd;

    public function __construct(string $locationCode, bool $multiAirportCityInd)
    {
        $this->multiAirportCityInd = $multiAirportCityInd;
        $this->changeLocationCode($locationCode);
    }

    private function changeLocationCode(string $locationCode) : void
    {
        if (!preg_match('/^[A-Z]{3}$/', $locationCode)) {
            {
                throw new InvalidArgumentException(
                    'Invalid OriginLocation.LocationCode value provided. Valid IATA code must be used'
                );
            }
        }
        $this->locationCode = $locationCode;
    }

    public function getValue() : array
    {
        return [
            'LocationCode' => $this->locationCode,
            'MultiAirportCityInd' => $this->multiAirportCityInd
        ];
    }
}
