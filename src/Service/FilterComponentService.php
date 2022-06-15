<?php

namespace App\Service;

use App\Entity\Filter;
use Doctrine\Common\Collections\Criteria;

class FilterComponentService
{
    public static function findByField(Filter $filter, $repository): array
    {
        return $repository->createQueryBuilder('c')
            ->addCriteria(self::createContainsCriteria($filter))
            ->getQuery()
            ->getResult();
    }

    protected static function createContainsCriteria(Filter $filter): Criteria
    {
        return Criteria::create()
            ->andWhere(Criteria::expr()->contains($filter->getField(), $filter->getValue()));
    }

}