<?php

namespace App\Repository;

use App\Entity\Salarie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Salarie>
 */
class SalarieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Salarie::class);
    }

    /**
     * Recherche par site et/ou compétences.
     * Un salarié est retourné s'il possède AU MOINS une des compétences cochées.
     *
     * @param int[] $competenceIds
     * @return Salarie[]
     */
    public function rechercher(?int $siteId, array $competenceIds = []): array
    {
        $qb = $this->createQueryBuilder('s')
            ->leftJoin('s.site', 'si')->addSelect('si')
            ->leftJoin('s.competences', 'c')->addSelect('c')
            ->orderBy('s.nom', 'ASC');

        if ($siteId) {
            $qb->andWhere('si.id = :site')->setParameter('site', $siteId);
        }

        if ($competenceIds) {
            $sub = $this->createQueryBuilder('s2')
                ->select('s2.id')
                ->join('s2.competences', 'c2')
                ->where('c2.id IN (:comps)');
            $qb->andWhere($qb->expr()->in('s.id', $sub->getDQL()))
               ->setParameter('comps', $competenceIds);
        }

        return $qb->getQuery()->getResult();
    }
}
