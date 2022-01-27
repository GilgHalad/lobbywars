<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Signatures;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         /* ----------- RENTAL ------------*/

        $signature = new Signatures();
        $signature->setName('King');
        $signature->setAbbreviation('K');
        $signature->setPoint(5);
        $manager->persist($signature);

        $signature = new Signatures();
        $signature->setName('Notary');
        $signature->setAbbreviation('N');
        $signature->setPoint(2);
        $manager->persist($signature);

        $signature = new Signatures();
        $signature->setName('Validator');
        $signature->setAbbreviation('V');
        $signature->setPoint(1);
        $manager->persist($signature);

        $manager->flush();
    }
}
