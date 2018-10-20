<?php

namespace TK\SDK\ValueObject\Factory;

use TK\SDK\Exception\InvalidArgumentException;
use TK\SDK\ValueObject\RetrieveReservationDetailParameters;

class RetrieveReservationDetailParametersFactory implements ValueObjectFactoryInterface
{
    /**
     * @param array $parameters
     * @return RetrieveReservationDetailParameters
     * @throws \Exception
     */
    public static function createFromArray(array $parameters): RetrieveReservationDetailParameters
    {
         return new RetrieveReservationDetailParameters($parameters['UniqueId'], $parameters['Surname']);
    }


    /**
     * @param string $json
     * @return RetrieveReservationDetailParameters
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public static function createFromJson(string $json): RetrieveReservationDetailParameters
    {
        $parameters = json_decode($json, (bool)JSON_OBJECT_AS_ARRAY);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(
                'RetrieveReservationDetailParametersFactory Error: ' . json_last_error_msg()
            );
        }
        return self::createFromArray($parameters);
    }
}
