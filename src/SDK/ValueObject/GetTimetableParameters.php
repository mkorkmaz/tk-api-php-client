<?php
declare(strict_types=1);

namespace TK\SDK\ValueObject;

use DateTimeImmutable;
use TK\SDK\Exception\InvalidArgumentException;

final class GetTimetableParameters implements ValueObjectInterface
{
    public const TRIP_TYPE_ROUND_TRIP = 'R';
    public const TRIP_TYPE_ONE_WAY = 'O';
    public const SCHEDULE_TYPE_WEEKLY = 'W';
    public const SCHEDULE_TYPE_MONTHLY = 'M';
    public const SCHEDULE_TYPE_DAILY = 'D';

    private static $tripTypeEnum = ['O','R'];
    private static $scheduleTypeEnum = ['D', 'M', 'W'];

    private $queryParameters;

    public function __construct(
        AirScheduleRQ $airScheduleRQ,
        string $scheduleType,
        string $tripType
    ) {
        $this->queryParameters['OTA_AirScheduleRQ'] = $airScheduleRQ->getValue();
        $this->setScheduleType($scheduleType);
        $this->setTripType($tripType);
    }

    public function withReturnDate(?DateTimeImmutable $returnDate) : GetTimetableParameters
    {
        $this->setReturnDate($returnDate);
        return $this;
    }

    private function setTripType(string $tripType) : void
    {
        if (! \in_array($tripType, self::$tripTypeEnum, true)) {
            throw new InvalidArgumentException(
                'Invalid Trip Type. Possible values are "' .
                implode(', ', self::$tripTypeEnum) . '"' .
                ' but provided value is "'. $tripType .'"'
            );
        }
        $this->queryParameters['tripType'] = $tripType;
    }

    private function setReturnDate(?DateTimeImmutable $returnDate) : void
    {
        if ($returnDate !== null) {
            $this->queryParameters['returnDate'] =  $returnDate->format('Y-m-d');
        }
    }

    private function setScheduleType(string $scheduleType) : void
    {
        if (! \in_array($scheduleType, self::$scheduleTypeEnum, true)) {
            throw new InvalidArgumentException(
                'Invalid Trip Type. Possible values are "' .
                implode(', ', self::$scheduleTypeEnum) . '"' .
                ' but provided value is "'. $scheduleType .'"'
            );
        }
        $this->queryParameters['scheduleType'] = $scheduleType;
    }

    public function getValue() : array
    {
        return $this->queryParameters;
    }
}
