<?php

namespace App\Repository;

use App\Entity\Ranking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ranking>
 */
class RankingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ranking::class);
    }

    public function getAll(): array
    {
        return $this->findAll();
    }

    public function findLatestShapshotDate(): ?\DateTimeImmutable
    {
        $result = $this->createQueryBuilder('r')
            ->select('r.snapshotDate')
            ->orderBy('r.snapshotDate', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $result['snapshotDate'] ?? null;
    }

    public function findPreviousSnapshotDate(\DateTimeImmutable $before): ?\DateTimeImmutable
    {
        $result = $this->createQueryBuilder('r')
            ->select('r.snapshotDate')
            ->where('r.snapshotDate <= :before')
            ->setParameter(':before', date($before->format('Y-m-d H:i:s')))
            ->orderBy('r.snapshotDate', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $result['snapshotDate'] ?? null;
    }

    public function findBySnapshotDate(\DateTimeImmutable $snapshotDate): array
    {
        $rankings = $this->createQueryBuilder('r')
            ->addSelect('t')
            ->join('r.team', 't')
            ->where('r.snapshotDate = :date')
            ->setParameter('date', $snapshotDate)
            ->orderBy('r.position', 'ASC')
            ->getQuery()
            ->getResult();

        $byTeam = [];

        foreach ($rankings as $ranking) {
            $byTeam[$ranking->getTeam()->getName()] = $ranking;
        }

        return $byTeam;
    }
}
