<?php

namespace App\DataFixtures;

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

        $fixture = new Resistor();
        $fixture->setName('R1');
        $fixture->setValue('1n');
        $fixture->setTolerance(10);
        $fixture->setPrice(0.01);
        $fixture->setUser($user);
        $fixture->setPower(1);
        $fixture->setPackage('0603');
        $manager->persist($fixture);

        $fixture = new Resistor();
        $fixture->setName('R2');
        $fixture->setValue('1u');
        $fixture->setTolerance(5);
        $fixture->setPrice(0.01);
        $fixture->setUser($user);
        $fixture->setPower(1);
        $fixture->setPackage('0603');
        $manager->persist($fixture);
        $manager->flush();
    }
}
