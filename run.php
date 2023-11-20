<?php

require "vendor/autoload.php";

use Testphp\Testphp\Order\OrderAvailability\BillingPeriod;
use Testphp\Testphp\Order\OrderAvailability\OrderAvailabilityDecisionMaker;
use Testphp\Testphp\Order\OrderAvailability\OrderLockModel;

$billingPeriod = new BillingPeriod(
    1,
    2024,
    new DateTimeImmutable("01.12.2023"),
    new DateTimeImmutable("31.12.2023")
);

$decision = new OrderAvailabilityDecisionMaker($billingPeriod);

$lock = new OrderLockModel(10, OrderLockModel::DIRECTION_FROM_END);
$decision->addLockDays($lock);
$newLock = new OrderLockModel(5, OrderLockModel::DIRECTION_FROM_BEGINING);
$decision->addLockDays($newLock);

print_r($decision->getEffectiveDays()[1]);