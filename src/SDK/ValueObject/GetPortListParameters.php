<?php
declare(strict_types=1);

namespace TK\SDK\ValueObject;

use TK\SDK\Exception\InvalidArgumentException;

final class GetPortListParameters implements ValueObjectInterface
{
    public const AIRLINE_CODE_TURKISH_AIRLINES = 'TK';
    public const AIRLINE_CODE_ANADOLUJET =  'AJ';
    public const LANGUAGE_CODE_TR = 'TR';
    public const LANGUAGE_CODE_EN = 'EN';
    public const LANGUAGE_CODE_DE = 'DE';

    private static $airlineCodeEnum = ['TK', 'AJ'];
    private static $languageCodeEnum = ['TR', 'EN', 'DE'];

    private $airlineCode;
    private $languageCode;

    public function __construct(string $airlineCode)
    {
        $this->setAirlineCode($airlineCode);
    }

    private function setAirlineCode(?string $airlineCode) : void
    {
        if (! \in_array($airlineCode, self::$airlineCodeEnum, true)) {
            throw new InvalidArgumentException(
                'Invalid AirlineCode provided. Must be one of these: "TK", "AJ"'
            );
        }
        $this->airlineCode = $airlineCode;
    }

    private function setLanguageCode(?string $languageCode) : void
    {
        if (! \in_array($languageCode, self::$languageCodeEnum, true)) {
            throw new InvalidArgumentException(
                'Invalid LanguageCode provided. Must be one of these: "TR", "EN", "DE"'
            );
        }
        $this->languageCode = $languageCode;
    }

    public function withLanguageCode(string $languageCode) : GetPortListParameters
    {
        $this->setLanguageCode($languageCode);
        return $this;
    }

    public function getValue() : array
    {
        $getPortListParameters = [
            'airlineCode' => $this->airlineCode
        ];
        if ($this->languageCode !== null) {
            $getPortListParameters['languageCode'] = $this->languageCode;
        }
        return $getPortListParameters;
    }
}
