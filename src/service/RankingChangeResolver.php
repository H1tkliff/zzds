<?php

namespace App\service;

use App\Repository\RankingRepository;

class RankingChangeResolver
{
    public function __construct(private RankingRepository $rankingRepository)
    {
    }

    public function getLatestRankingWithChange(): array
    {
        $latest = $this->rankingRepository->findLatestShapshotDate();

        if ($latest === null) {
            return [];
        }

        $current = $this->rankingRepository->findBySnapshotDate($latest);

        $previousDate = $this->rankingRepository->findPreviousSnapshotDate($latest);
        $previous = $previousDate !== null
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