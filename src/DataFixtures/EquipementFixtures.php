<?php

namespace App\DataFixtures;

use App\Entity\Equipement;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class EquipementFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['equipement'];
    }
    public function load(ObjectManager $manager): void
    {
        $equip1 = new Equipement();
        $equip1-> setName('lave-linge');
        $manager->persist($equip1);
 
        $equip2 = new Equipement();
        $equip2-> setName('lave-vaiselle');
        $manager->persist($equip2);
 
        $equip3 = new Equipement();
        $equip3-> setName('climatisation');
        $manager->persist($equip3);
 
        $equip4 = new Equipement();
        $equip4-> setName('télévision');
        $manager->persist($equip4);
 
           
        $manager->flush();
    }
}
