<?php

namespace App\Repository;

use App\Entity\CompetenceTraduction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompetenceTraduction>
 */
class CompetenceTraductionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompetenceTraduction::class);
    }
}
