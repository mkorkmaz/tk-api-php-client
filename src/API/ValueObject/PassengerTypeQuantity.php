<?php
declare(strict_types=1);

namespace TK\API\ValueObject;

use TK\API\Exception\InvalidArgumentException;

final class PassengerTypeQuantity implements ValueObjectInterface
{
    public const PASSENGER_TYPE_ADULT = 'adult';
    public const PASSENGER_TYPE_CHILD = 'child';
    public const PASSENGER_TYPE_INFANT = 'infant';

    private static $passengerTypeEnum = ['adult', 'child', 'infant'];

    private $quantities;

    public function __construct()
    {
        $this->quantities = [];
    }

    public function withQuantity(string $passengerTye, int $quantity) : PassengerTypeQuantity
    {
        $this->checkPassengerType($passengerTye);
        $this->quantities[] = [
            'Code' => $passengerTye,
            'Quantity' => $quantity
        ];
        return $this;
    }

    private function checkPassengerType(string $checkPassengerType) : void
    {
        if (!\in_array($checkPassengerType, self::$passengerTypeEnum, true)) {
            throw new InvalidArgumentException(
                'Invalid PassengerTypeQuantity.Code value provided. Must be one of these: ' .
                implode(', ', self::$passengerTypeEnum)
            );
        }
    }

    public function getValue() : array
    {
        return $this->quantities;
    }
}
