<?php

namespace App\DataFixtures;

use App\Entity\Player;
use App\Entity\Team;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

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

        $user = new User();
        $user->setName('admin');
        $user->setSurname('admin');
        $user->setEmail('admin@test.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword(
            $this->hasher->hashPassword($user, 'password123')
        );

        $manager->persist($player);
        $manager->persist($team);
        $manager->persist($user);
        $manager->flush();
    }
}
