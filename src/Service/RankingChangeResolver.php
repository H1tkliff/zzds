<?php

namespace App\Service;

use App\Repository\RankingRepository;

class RankingChangeResolver
{
    public function __construct(private RankingRepository $rankingRepository)
    {
    }

    public function getLatestRankingWithChange(): array
    {
        $latest = $this->rankingRepository->findLatestShapshotDate();

        if (null === $latest) {
            return [];
        }

        $current = $this->rankingRepository->findBySnapshotDate($latest);

        $previousDate = $this->rankingRepository->findPreviousSnapshotDate($latest);
        $previous = null !== $previousDate
            ? $this->rankingRepository->findBySnapshotDate($previousDate)
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
