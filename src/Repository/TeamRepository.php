<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Team>
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    /**
     * Teams with players and discipline in one query (the team list renders both).
     *
     * @return Team[]
     */
    public function findAllWithPlayers(): array
    {
        return $this->createQueryBuilder('t')
            ->addSelect('p', 'd')
            ->leftJoin('t.players', 'p')
            ->leftJoin('t.discipline', 'd')
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
