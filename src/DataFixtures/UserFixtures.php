<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $userAdmin = new User();
        $userAdmin->setName('admin');
        $userAdmin->setSurname('admin');
        $userAdmin->setEmail('ilyagromovoy83@gmail.com');
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $userAdmin->setPassword(
            $this->hasher->hashPassword($userAdmin, 'password123!')
        );

        $user = new User();
        $user->setName('Sasha');
        $user->setSurname('Prikotko');
        $user->setEmail('alatont@test.mail');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword(
            $this->hasher->hashPassword($user, 'password123')
        );

        $manager->persist($userAdmin);
        $manager->persist($user);
        $manager->flush();
    }
}
