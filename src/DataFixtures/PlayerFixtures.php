<?php

namespace App\DataFixtures;

use App\Entity\Player;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PlayerFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $players = [
            ['nickname' => 'Alaront', 'rating' => 1.18, 'team' => TeamFixtures::KAMBROD],
            ['nickname' => 'VafelPafel', 'rating' => 0.97, 'team' => TeamFixtures::KAMBROD],
            ['nickname' => 'Тихий Дэн', 'rating' => 1.05, 'team' => TeamFixtures::ROTA],
            ['nickname' => 'Valera', 'rating' => 0.91, 'team' => TeamFixtures::ROTA],
            ['nickname' => 'Вездессун', 'rating' => 1.22, 'team' => TeamFixtures::CHMOGATIRI],
            ['nickname' => 'Mrazish Χριστός', 'rating' => 1.09, 'team' => TeamFixtures::CHMOGATIRI],
            ['nickname' => 'Nelatod', 'rating' => 0.88, 'team' => TeamFixtures::FIXIS],
            ['nickname' => 'Ivan', 'rating' => 1.01, 'team' => TeamFixtures::FIXIS],
            ['nickname' => 'Saseb1', 'rating' => 1.14, 'team' => TeamFixtures::VZVOD],
            ['nickname' => 'Saseb2', 'rating' => 0.95, 'team' => TeamFixtures::VZVOD],
        ];

        foreach ($players as $data) {
            $player = new Player();
            $player->setNickname($data['nickname']);
            $player->setRating($data['rating']);
            $player->setTeam($this->getReference($data['team'], Team::class));
            $manager->persist($player);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [TeamFixtures::class];
    }

    public static function getGroups(): array
    {
        return ['live'];
    }
}
