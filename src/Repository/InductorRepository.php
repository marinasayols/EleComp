<?php

namespace App\Repository;

use App\Entity\Inductor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Inductor>
 *
 * @method Inductor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inductor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inductor[]    findAll()
 * @method Inductor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InductorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inductor::class);
    }
}
