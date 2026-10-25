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
            self::CS2 => ['name' => 'CS2', 'slug' => 'cs2'],
            self::HEARTHSTONE => ['name' => 'Hearthstone', 'slug' => 'hearthstone'],
        ];

        foreach ($disciplines as $reference => $data) {
            $discipline = new Discipline();
            $discipline->setName($data['name']);
            $discipline->setSlug($data['slug']);
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
