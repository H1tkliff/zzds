<?php

namespace App\Service;

use App\Entity\Discipline;
use App\Repository\RankingRepository;

class RankingChangeResolver
{
    public function __construct(private RankingRepository $rankingRepository)
    {
    }

    public function getLatestRankingWithChange(Discipline $discipline): array
    {
        $latest = $this->rankingRepository->findLatestSnapshotDate($discipline);

        if (null === $latest) {
            return [];
        }

        $current = $this->rankingRepository->findBySnapshotDate($discipline, $latest);

        $previousDate = $this->rankingRepository->findPreviousSnapshotDate($discipline, $latest);
        $previous = null !== $previousDate
            ? $this->rankingRepository->findBySnapshotDate($discipline, $previousDate)
            : [];

        $result = [];
        foreach ($current as $teamId => $ranking) {
            $change = isset($previous[$teamId])
                ? $previous[$teamId]->getPosition() - $ranking->getPosition()
                : null; // null - new in Ranking
            $result[] = ['ranking' => $ranking, 'change' => $change];
        }

        usort($result, fn ($a, $b) => $a['ranking']->getPosition() <=> $b['ranking']->getPosition());

        return $result;
    }
}
