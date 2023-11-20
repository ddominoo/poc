<?php

namespace Testphp\Testphp\Order\OrderAvailability;

class OrderLockModel
{

    public const DIRECTION_FROM_END = 1;
    public const DIRECTION_FROM_BEGINING = 2;

    public function __construct(
        private readonly int $days,
        private readonly int$direction
    ){}

    public function getDays(): int
    {
        return $this->days;
    }

    public function getDirection(): int
    {
        return $this->direction;
    }
}