<?php

namespace App\DataFixtures;

use App\Entity\Ranking;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RankingFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function getDependencies(): array
    {
        return [TeamFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $snapshots = [
            [
                'date' => new \DateTimeImmutable(),
                'entries' => [
                    [TeamFixtures::CHMOGATIRI, 1842, 1.35, 1],
                    [TeamFixtures::VZVOD, 1790, 1.28, 2],
                    [TeamFixtures::KAMBROD, 1755, 1.24, 3],
                    [TeamFixtures::ROTA, 1698, 1.19, 4],
                    [TeamFixtures::FIXIS, 1644, 1.15, 5],
                ],
            ],
            [
                'date' => new \DateTimeImmutable('-7 days'),
                'entries' => [
                    [TeamFixtures::VZVOD,      1800, 1.30, 1],
                    [TeamFixtures::CHMOGATIRI, 1760, 1.25, 2],
                    [TeamFixtures::KAMBROD,    1755, 1.24, 3],
                    [TeamFixtures::ROTA,       1700, 1.20, 4],
                    [TeamFixtures::FIXIS,      1650, 1.15, 5],
                ],
            ],
        ];

        foreach ($snapshots as $snapshot) {
            foreach ($snapshot['entries'] as [$teamReference, $points, $rating, $position]) {
                $ranking = new Ranking();
                $ranking->setTeam($this->getReference($teamReference, Team::class));
                $ranking->setPoints($points);
                $ranking->setRating($rating);
                $ranking->setPosition($position);
                $ranking->setSnapshotDate($snapshot['date']);
                $manager->persist($ranking);
            }
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}
