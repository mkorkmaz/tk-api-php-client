<?php
declare(strict_types=1);

namespace TK\SDK\ValueObject;

class RetrieveReservationDetailParameters implements ValueObjectInterface
{
    private $uniqueId;
    private $surname;

    public function __construct(string $uniqueId, string $surname)
    {
        $this->uniqueId = $uniqueId;
        $this->surname = $surname;
    }

    public function getValue() : array
    {
        return [
            'UniqueId' => $this->uniqueId,
            'Surname' => $this->surname
        ];
    }
}
