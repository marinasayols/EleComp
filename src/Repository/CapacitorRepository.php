<?php

namespace App\Repository;

use App\Entity\Capacitor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Capacitor>
 *
 * @method Capacitor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Capacitor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Capacitor[]    findAll()
 * @method Capacitor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CapacitorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Capacitor::class);
    }
}