<?php
declare(strict_types=1);

namespace TK\SDK\ValueObject;

use TK\SDK\Exception\InvalidArgumentException;

final class GetAvailabilityParameters implements ValueObjectInterface
{

    public const ROUTING_TYPE_ROUND_TRIP = 'r';
    public const ROUTING_TYPE_ONE_WAY = 'o';
    public const REDUCED_DATA_INDICATOR_TRUE  = true;
    public const REDUCED_DATA_INDICATOR_FALSE  = false;
    private static $routingTypeEnum = ['o', 'r'];

    private $queryParameters = [
        'OriginDestinationInformation' => [],
        'ReducedDataIndicator' => false
    ];

    public function __construct(
        bool $reducedDataIndicator,
        string $routingType,
        PassengerTypeQuantity $passengerTypeQuantity
    ) {
        $this->queryParameters['ReducedDataIndicator'] = $reducedDataIndicator;
        $this->setRoutingType($routingType);
        $this->queryParameters['PassengerTypeQuantity'] = $passengerTypeQuantity->getValue();
    }

    private function setRoutingType(string $routingType) : void
    {
        if (! \in_array($routingType, self::$routingTypeEnum, true)) {
            throw new InvalidArgumentException(
                'Invalid Trip Type. Possible values are "' .
                implode(', ', self::$routingTypeEnum) . '"' .
                ' but provided value is "'. $routingType .'"'
            );
        }
        $this->queryParameters['RoutingType'] = $routingType;
    }

    public function withTargetSource() : GetAvailabilityParameters
    {
        $this->queryParameters['TargetSource'] = 'AWT';
        return $this;
    }

    public function withOriginDestinationInformation(
        OriginDestinationInformation $originDestinationInformation
    ) : GetAvailabilityParameters {
        $this->queryParameters['OriginDestinationInformation'][] = $originDestinationInformation->getValue();
        return $this;
    }

    public function getValue() : array
    {
        return $this->queryParameters;
    }
}
