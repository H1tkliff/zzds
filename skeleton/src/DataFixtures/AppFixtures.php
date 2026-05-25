<?php

namespace App\DataFixtures;

use App\Entity\Discipline;
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

        $userAdmin = new User();
        $userAdmin->setName('admin');
        $userAdmin->setSurname('admin');
        $userAdmin->setEmail('admin@test.com');
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $userAdmin->setPassword(
            $this->hasher->hashPassword($userAdmin, 'password123')
        );

        $user = new User();
        $user->setName('Sasha');
        $user->setSurname('Prikotko');
        $user->setEmail('alatont@test.mail');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword(
            $this->hasher->hashPassword($user, 'password123')
        );

        $disciplineCS = new Discipline();
        $disciplineCS->setName('CS2');

        $disciplineHS = new Discipline();
        $disciplineHS->setName('Hearthstone');

        $manager->persist($player);
        $manager->persist($team);
        $manager->persist($userAdmin);
        $manager->persist($user);
        $manager->persist($disciplineCS);
        $manager->persist($disciplineHS);
        $manager->flush();
    }
}
