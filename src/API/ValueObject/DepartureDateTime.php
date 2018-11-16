<?php
declare(strict_types=1);

namespace TK\API\ValueObject;

use DateTimeImmutable;
use TK\API\Exception\InvalidArgumentException;

final class DepartureDateTime implements ValueObjectInterface
{
    private $date;
    private $windowAfter;
    private $windowBefore;

    private $dateFormat = 'Y-m-d';

    public function __construct(DateTimeImmutable $date, string $windowAfter, string $windowBefore)
    {
        $this->setDate($date);
        $this->setWindowBefore($windowBefore);
        $this->setWindowAfter($windowAfter);
    }

    private function setDate(DateTimeImmutable $date) : void
    {
        $this->date = $date;
    }

    private function setWindowBefore(string $windowBefore) : void
    {
        if (!preg_match('/^P[0-3]{1}D$/', $windowBefore)) {
            throw new InvalidArgumentException(
                'Invalid DepartureDateTime.WindowBefore value provided. Format should be like this P{int:[0,1,2,3]}D'
            );
        }
        $this->windowBefore = $windowBefore;
    }

    private function setWindowAfter(string $windowAfter) : void
    {
        if (!preg_match('/^P[0-3]{1}D$/', $windowAfter)) {
            throw new InvalidArgumentException(
                'Invalid DepartureDateTime.WindowAfter value provided. Format should be like this P{int:[0,1,2,3]}D'
            );
        }
        $this->windowAfter = $windowAfter;
    }

    public function withDateFormat(string $dateFormat) : DepartureDateTime
    {
        $this->dateFormat = $dateFormat;
        return $this;
    }

    public function getValue() : array
    {
        return [
            'Date' => strtoupper($this->date->format($this->dateFormat)),
            'WindowBefore' => $this->windowBefore,
            'WindowAfter' => $this->windowAfter
        ];
    }
}
