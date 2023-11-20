<?php

namespace Testphp\Testphp\Order\OrderAvailability;

use DateTimeImmutable;

class BillingPeriod implements BillingPeriodInterface
{
    public function __construct(
        private readonly int $number,
        private readonly int $year,
        private readonly DateTimeImmutable $dateFrom,
        private readonly DateTimeImmutable $dateTo

    ){}

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getDateFrom(): DateTimeImmutable
    {
        return $this->dateFrom;
    }

    public function getDateTo(): DateTimeImmutable
    {
        return $this->dateTo;
    }
}