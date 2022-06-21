<?php

namespace App\DataFixtures;

use App\Entity\Capacitor;
use App\Entity\Inductor;
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
        $R1->setPower(5);
        $R1->setPackage('0603');
        $manager->persist($R1);

        $R2 = new Resistor();
        $R2->setName('R2');
        $R2->setValue('1u');
        $R2->setTolerance(5);
        $R2->setPrice(2.0);
        $R2->setUser($user);
        $R2->setPower(1);
        $R2->setPackage('1206');
        $manager->persist($R2);

        $C1 = new Capacitor();
        $C1->setName('C1');
        $C1->setValue('3n');
        $C1->setTolerance(5);
        $C1->setPrice(0.05);
        $C1->setUser($user);
        $C1->setVoltage(20);
        $C1->setTemperatureCoefficient('X5R');
        $manager->persist($C1);

        $C2 = new Capacitor();
        $C2->setName('C2');
        $C2->setValue('3n');
        $C2->setTolerance(10);
        $C2->setPrice(0.01);
        $C2->setUser($user);
        $C2->setVoltage(10);
        $C2->setTemperatureCoefficient('NPR');
        $manager->persist($C2);

        $L1 = new Inductor();
        $L1->setName('L1');
        $L1->setValue('3m');
        $L1->setTolerance(10);
        $L1->setPrice(0.01);
        $L1->setUser($user);
        $L1->setMaxCurrent(0.05);
        $L1->setDCResistance(5);
        $manager->persist($L1);

        $L2 = new Inductor();
        $L2->setName('L2');
        $L2->setValue('20m');
        $L2->setTolerance(10);
        $L2->setPrice(0.01);
        $L2->setUser($user);
        $L2->setMaxCurrent(0.01);
        $L2->setDCResistance(13);
        $manager->persist($L2);

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
