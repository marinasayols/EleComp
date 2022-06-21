<?php

namespace App\Repository;

use App\Entity\ProjectItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProjectItem>
 *
 * @method ProjectItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectItem[]    findAll()
 * @method ProjectItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectItem::class);
    }
}
