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
            ->setRoles(["ROLE_ADMIN"])
            ->setEmail('admin@deouf.com')
            ->setSurname('admin')
            ->setlastName('nimda')
            ->setPhone('0606060606')
            ->setAddress('la rue d\'ici')
            ->setZipcode('89200')
            ->setCity('Avallon City Beach');
        $manager->persist($admin);
        $manager->flush();

        $user = new User();
        $user
            ->setUsername("john")
            ->setPassword($this->hasher->hashpassword($user, "doe"))
            ->setRoles(["ROLE_USER"])
            ->setEmail('john@doe.com')
            ->setSurname('John')
            ->setlastName('Doe')
            ->setPhone('0666000000')
            ->setAddress('9 place de Judas')
            ->setZipcode('666')
            ->setCity('HellOnEarth');
        $manager->persist($user);
        $manager->flush();
    }
}
