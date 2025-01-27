<?php

namespace App\Domain\Entity;

use DateInterval;

interface SoftDeleteableInFutureInterface
{
    public function setDeletedAtInFuture(DateInterval $dateInterval): void;
}
