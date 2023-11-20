<?php

namespace Testphp\Testphp\Order\OrderAvailability;

use DateTimeImmutable;

interface BillingPeriodInterface
{
    public function getNumber(): int;
    public function getYear(): int;
    public function getDateFrom(): DateTimeImmutable;
    public function getDateTo(): DateTimeImmutable;
}