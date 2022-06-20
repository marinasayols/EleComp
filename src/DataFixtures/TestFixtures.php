<?php

namespace App\DataFixtures;

use App\Entity\Capacitor;
use App\Entity\Project;
use App\Entity\ProjectItem;
use App\Entity\Resistor;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TestFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@example.com');
        $user->setPassword('123456');
        $manager->persist($user);

        $R1 = new Resistor();
        $R1->setName('R1');
        $R1->setValue('1n');
        $R1->setTolerance(10);
        $R1->setPrice(0.01);
        $R1->setUser($user);
        $R1->setPower(1);
        $R1->setPackage('0603');
        $manager->persist($R1);

        $R2 = new Resistor();
        $R2->setName('R2');
        $R2->setValue('1u');
        $R2->setTolerance(5);
        $R2->setPrice(0.01);
        $R2->setUser($user);
        $R2->setPower(1);
        $R2->setPackage('0603');
        $manager->persist($R2);

        $C1 = new Capacitor();
        $C1->setName('C1');
        $C1->setValue('1u');
        $C1->setTolerance(5);
        $C1->setPrice(0.01);
        $C1->setUser($user);
        $C1->setVoltage(20);
        $C1->setTemperatureCoefficient('X5R');
        $manager->persist($C1);

        $p1 = new Project();
        $p1->setName('Test');
        $p1->setDescription('Description');
        $p1->setUser($user);
        $manager->persist($p1);

        $p2 = new Project();
        $p2->setName('Project1');
        $p2->setDescription('Description');
        $p2->setUser($user);
        $manager->persist($p2);

        $projectItem = new ProjectItem();
        $projectItem->setProject($p1);
        $projectItem->setComponent($C1);
        $projectItem->setQty(3);
        $manager->persist($projectItem);


        $manager->flush();

    }
}
