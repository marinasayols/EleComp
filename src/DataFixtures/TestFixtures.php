<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

class TestFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $loader = new NativeLoader();
        $objectSet = $loader->loadFile(__DIR__ . '/test_fixtures.yml')->getObjects();
        foreach ($objectSet as $obj) {
            $manager->persist($obj);
        }
        $manager->flush();
    }
}
