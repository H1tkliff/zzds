<?php

namespace App\DataFixtures;

use App\Entity\Player;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $team = new Team();

        $teams = ["Navi", "Team Spirit", "Chmogatiri"];
        foreach ($teams as $teamName) {
            $team->setName($teamName);
            $manager->persist($team);
        }

        $player = new Player();
        $player->setNickname("Alaront");
        $player->setRating(1.50);
        $player->setTeam($team);


        $manager->persist($player);
        $manager->persist($team);
        $manager->flush();
    }
}
