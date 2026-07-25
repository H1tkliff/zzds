<?php

namespace App\DataFixtures;

use App\Entity\Discipline;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TeamFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public const ROTA = 'team_47_rota';
    public const VZVOD = 'team_vzvod';
    public const CHMOGATIRI = 'team_chmogatiri';
    public const KAMBROD = 'team_kambrod';
    public const FIXIS = 'team_fixis';


    public function load(ObjectManager $manager): void
    {
        $teams = [
            self::ROTA => ['name' => '47 рота', 'discipline' => DisciplineFixtures::CS2],
            self::VZVOD => ['name' => 'VZvod', 'discipline' => DisciplineFixtures::CS2],
            self::CHMOGATIRI => ['name' => '4moGaTyri', 'discipline' => DisciplineFixtures::CS2],
            self::KAMBROD => ['name' => 'Камбродские люркеры', 'discipline' => DisciplineFixtures::CS2],
            self::FIXIS => ['name' => 'Пьяные фиксики', 'discipline' => DisciplineFixtures::CS2],
        ];

        foreach ($teams as $reference => $data) {
            $team = new Team();
            $team->setName($data['name']);
            $team->setDiscipline($this->getReference($data['discipline'], Discipline::class));
            $manager->persist($team);

            $this->addReference($reference, $team);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [DisciplineFixtures::class];
    }

    public static function getGroups(): array
    {
        return ['live'];
    }
}
