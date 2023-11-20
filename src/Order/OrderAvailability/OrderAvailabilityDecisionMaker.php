<?php

namespace Testphp\Testphp\Order\OrderAvailability;



use DateTime;
use DateTimeImmutable;

class OrderAvailabilityDecisionMaker
{
    private array $effectiveOrderDays = [];

    public function __construct(
        private readonly BillingPeriodInterface $billingPeriod,
    )
    {
        $days = date_diff($this->billingPeriod->getDateTo(), $this->billingPeriod->getDateFrom());
        $baseDate = new DateTime(
            date(
                "d.m.Y",
                $this->billingPeriod->getDateFrom()->getTimestamp()
            )
        );
        for($i = 1; $i <= $days->days; $i++) {
            $this->effectiveOrderDays[$i] = $baseDate->modify("+1 day")->format('d.m.Y');
        }

    }

    public function addLockDays(OrderLockModel $lockModel): void
    {
        if ($lockModel->getDirection() === OrderLockModel::DIRECTION_FROM_BEGINING) {
            array_splice($this->effectiveOrderDays, $lockModel->getDays()*-1);
        } else {
            array_splice($this->effectiveOrderDays, 0, $lockModel->getDays());
        }
    }

    public function getEffectiveDays(): array
    {
        return $this->effectiveOrderDays;
    }

    public function getEffectiveDaysAmount(): int
    {
        return count($this->effectiveOrderDays);
    }

    public function isOrderLockedInGivenDate(DateTimeImmutable $date): bool
    {
        return !in_array($date->format('d.m.Y'), $this->effectiveOrderDays, true);
    }

    public function daysTillOrderEnd(DateTimeImmutable $date): int
    {
        $key = array_search($date->format('d.m.Y'), $this->effectiveOrderDays, true);
        $endKey = array_key_last($this->effectiveOrderDays);
        return $endKey-$key;
    }

    public function daysTillOrderStart(DateTimeImmutable $date): int
    {
        $day = $date->format('d');
        if (isset($this->effectiveOrderDays[$day])) {
            return 0;
        }

        $days = 0;

        for ($x = $day; $x <= array_key_last($this->effectiveOrderDays); $x++) {
            if (isset($this->effectiveOrderDays[$x])) {
                $days = $x;
                break;
            }
        }

        return abs($days-$day);

    }
}