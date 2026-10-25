<?php

namespace App\Repository;

use App\Entity\Discipline;
use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Player>
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    /**
     * @return Player[]
     */
    public function findTopRated(Discipline $discipline, int $limit): array
    {
        // shortcut: uses the static Player.rating; switch to aggregated PlayerMapStats in step 1.5
        return $this->createQueryBuilder('p')
            ->addSelect('t')
            ->join('p.team', 't')
            ->where('t.discipline = :discipline')
            ->setParameter('discipline', $discipline)
            ->orderBy('p.rating', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
