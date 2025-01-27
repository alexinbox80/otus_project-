<?php

namespace App\Application\Doctrine;

use App\Domain\Entity\SoftDeleteableInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class SoftDeletedFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias): string
    {
        if (!$targetEntity->reflClass->implementsInterface(SoftDeleteableInterface::class)) {
            return '';
        }

        return $this->getParameter('checkTime') ?
            '('.$targetTableAlias.'.deleted_at IS NULL OR '.$targetTableAlias.'.deleted_at >= current_timestamp)' :
            $targetTableAlias.'.deleted_at IS NULL';
    }
}
