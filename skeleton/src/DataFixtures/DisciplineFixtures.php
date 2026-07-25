<?php

namespace App\DataFixtures;

use App\Entity\Discipline;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class DisciplineFixtures extends Fixture implements FixtureGroupInterface
{
    public const CS2 = 'discipline_cs2';
    public const HEARTHSTONE = 'discipline_hearthstone';

    public function load(ObjectManager $manager): void
    {
        $disciplines = [
            self::CS2 => 'CS2',
            self::HEARTHSTONE => 'Hearthstone',
        ];

        foreach ($disciplines as $reference => $name) {
            $discipline = new Discipline();
            $discipline->setName($name);
            $manager->persist($discipline);

            $this->addReference($reference, $discipline);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['live'];
    }
}
