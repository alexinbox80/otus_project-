<?php

namespace App\Domain\Entity;

use DateTime;

interface SoftDeleteableInterface
{
    public function getDeletedAt(): ?DateTime;

    public function setDeletedAt(): void;
}
