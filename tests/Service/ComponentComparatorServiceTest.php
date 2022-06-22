<?php

namespace App\Tests\Service;

use App\DataFixtures\TestFixtures;
use App\Entity\Component;
use App\Repository\ComponentRepository;
use App\Service\ComponentComparatorService;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ComponentComparatorServiceTest extends KernelTestCase
{
    protected $databaseTool;
    private ComponentRepository $repository;

    public function testCompareComponents()
    {
        $r1 = $this->repository->findOneBy(['name' => 'R1']);
        $r2 = $this->repository->findOneBy(['name' => 'R2']);
        $this->assertSame(-1, ComponentComparatorService::compareName($r1, $r2));
        $this->assertSame(-1, ComponentComparatorService::compareValue($r1, $r2));
        $this->assertSame(1, ComponentComparatorService::compareTolerance($r1, $r2));
        $this->assertSame(-1, ComponentComparatorService::comparePrice($r1, $r2));
    }

    public function testCompareResistors()
    {
        $r1 = $this->repository->findOneBy(['name' => 'R1']);
        $r2 = $this->repository->findOneBy(['name' => 'R2']);
        $this->assertSame(1, ComponentComparatorService::comparePower($r1, $r2));
        $this->assertSame(-1, ComponentComparatorService::comparePackage($r1, $r2));
    }

    public function testCompareCapacitors()
    {
        $c1 = $this->repository->findOneBy(['name' => 'C1']);
        $c2 = $this->repository->findOneBy(['name' => 'C2']);
        $this->assertSame(1, ComponentComparatorService::compareVoltage($c1, $c2));
        $this->assertSame(1, ComponentComparatorService::compareTemperatureCoefficient($c1, $c2));
    }

    public function testCompareInductors()
    {
        $l1 = $this->repository->findOneBy(['name' => 'L1']);
        $l2 = $this->repository->findOneBy(['name' => 'L2']);
        $this->assertSame(-1, ComponentComparatorService::compareMaxCurrent($l1, $l2));
        $this->assertSame(-1, ComponentComparatorService::compareDCResistance($l1, $l2));
    }

    public function setUp(): void
    {
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Component::class);
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->databaseTool->loadFixtures([TestFixtures::class]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }

}
