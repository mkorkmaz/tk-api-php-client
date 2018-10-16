<?php
declare(strict_types=1);

namespace TK\SDK\ValueObject;

class GetFareFamilyListParameters implements ValueObjectInterface
{
    private $portList;
    private $isMilesRequest = 'F';

    public function __construct()
    {
        $this->portList = [];
    }
    public function withPortIataCode(string $portIataCode) : GetFareFamilyListParameters
    {
        $this->checkPortIataCode($portIataCode);
        $this->portList[] = $portIataCode;
        return $this;
    }

    private function checkPortIataCode(string $portIataCode) : void
    {
        if (! preg_match('/[A-Z]{3}/', $portIataCode)) {
            {
                throw new InvalidArgumentException(
                    'Invalid portList value provided. Valid IATA code must be used.'
                );
            }
        }
    }

    public function withMilesRequest() : GetFareFamilyListParameters
    {
        $this->isMilesRequest = 'T';
        return $this;
    }

    public function getValue() : array
    {
        return [
            'portList' => $this->portList,
            'isMilesRequest' => $this->isMilesRequest
        ];
    }
}
