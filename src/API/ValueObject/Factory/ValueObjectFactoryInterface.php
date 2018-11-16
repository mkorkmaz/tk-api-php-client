<?php
declare(strict_types=1);

namespace TK\API\ValueObject\Factory;

interface ValueObjectFactoryInterface
{
    public static function createFromArray(array $parameters);
    public static function createFromJson(string $parameters);
}
