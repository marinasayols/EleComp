<?php

namespace App\Repository;

use App\Entity\Resistor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Resistor>
 *
 * @method Resistor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Resistor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Resistor[]    findAll()
 * @method Resistor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResistorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resistor::class);
    }
}
