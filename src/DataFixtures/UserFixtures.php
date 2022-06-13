<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin
            ->setUsername("admin")
            ->setPassword($this->hasher->hashpassword($admin, "admin"))
            ->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);
        $manager->flush();

        $user = new User();
        $user
            ->setUsername("john")
            ->setPassword($this->hasher->hashpassword($user, "doe"))
            ->setRoles(["ROLE_USER"]);
        $manager->persist($user);
        $manager->flush();
    }
}
