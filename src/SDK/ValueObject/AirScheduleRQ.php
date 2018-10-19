<?php
declare(strict_types=1);

namespace TK\SDK\ValueObject;

use TK\SDK\Exception\InvalidArgumentException;

final class AirScheduleRQ implements ValueObjectInterface
{
    public const AIRLINE_TURKISH_AIRLINES = 'TK';
    public const AIRLINE_ANADOLUJET = 'AJ';

    private static $airlineCodeEnum = ['TK', 'AJ'];

    private $directAndNonStopOnlyInd;
    private $airlineCode;
    private $originDestinationInformation;

    public function __construct(
        OriginDestinationInformation $originDestinationInformation
    ) {
        $this->originDestinationInformation = $originDestinationInformation;
    }

    public function withDirectAndNonStopOnlyInd() : AirScheduleRQ
    {
        $this->directAndNonStopOnlyInd = true;
        return $this;
    }

    public function withAirlineCode(string $airlineCode) : AirScheduleRQ
    {
        $this->setAirlineCode($airlineCode);
        return $this;
    }

    private function setAirlineCode(?string $airlineCode) : void
    {
        if (!\in_array($airlineCode, self::$airlineCodeEnum, true)) {
            throw new InvalidArgumentException(
                'Invalid AirlineCode provided. Must be one of these: "TK", "AJ"'
            );
        }
        $this->airlineCode = $airlineCode;
    }

    public function getValue() : array
    {
        $AirScheduleRQValue = [
            'OriginDestinationInformation' => $this->originDestinationInformation->getValue()
        ];
        if ($this->airlineCode !== null) {
            $AirScheduleRQValue['AirlineCode'] = $this->airlineCode;
        }
        if ($this->directAndNonStopOnlyInd !== null) {
            $AirScheduleRQValue['FlightTypePref'] = [
                'DirectAndNonStopOnlyInd' => $this->directAndNonStopOnlyInd
            ];
        }
        return $AirScheduleRQValue;
    }
}
