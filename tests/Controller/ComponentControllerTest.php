<?php

namespace App\Tests\Controller;

use App\DataFixtures\TestFixtures;
use App\Entity\Component;
use App\Entity\User;
use App\Repository\ComponentRepository;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ComponentControllerTest extends WebTestCase
{
    protected $databaseTool;
    private KernelBrowser $client;
    private ComponentRepository $repository;
    private string $path = '/component/';
    private string $tr = 'table tbody tr';
    private User $user;

    public function testShow()
    {
        $fixture = $this->repository->findOneBy(['name' => 'R1']);
        $this->client->request('GET', sprintf('%sshow/%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains($fixture->getName());
    }

    public function testNew()
    {
        $types = ['resistor', 'capacitor', 'inductor'];
        $fields = [
            'resistor' => ['resistor[power]' => 1, 'resistor[package]' => 'Testing'],
            'capacitor' => ['capacitor[voltage]' => 1, 'capacitor[temperatureCoefficient]' => 'Testing'],
            'inductor' => ['inductor[maxCurrent]' => 1.0, 'inductor[dCResistance]' => 1.0],
        ];
        foreach ($types as $type) {
            $originalNumObjectsInRepository = count($this->repository->findBy(['user' => $this->user]));
            $this->client->request('GET', sprintf('%snew/%s', $this->path, $type));

            self::assertResponseStatusCodeSame(200);

            $this->client->submitForm('Save', array_merge([
                $type . '[name]' => 'Testing',
                $type . '[value]' => 'Testing',
                $type . '[tolerance]' => 10,
                $type . '[price]' => 1
            ], $fields[$type]));

            self::assertResponseRedirects($this->path);
            self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findBy(['user' => $this->user])));
        }
    }

    public function testInitial()
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Component index');
        self::assertEquals(1, $crawler->filter('p#content')->count());
    }

    public function testEdit()
    {
        $fixture = $this->repository->findOneBy(['name' => 'R1']);
        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'resistor[value]' => 'New',
            'resistor[power]' => 5.0,
            'resistor[package]' => 'New',
        ]);

        self::assertResponseRedirects($this->path);

        $fixture = $this->repository->findAll();

        self::assertSame('New', $fixture[0]->getValue());
        self::assertEquals(5.0, $fixture[0]->getPower());
        self::assertSame('New', $fixture[0]->getPackage());
    }

    public function testListComponents()
    {
        $types = ['resistor', 'capacitor', 'inductor'];
        foreach ($types as $type) {
            $crawler = $this->client->request('GET', sprintf('%s%s', $this->path, $type));
            self::assertResponseStatusCodeSame(200);
            self::assertPageTitleContains('Component index');
            self::assertEquals(1, $crawler->filter('table#t-' . $type)->count());
        }
    }

    public function testSortUp()
    {
        $crawler = $this->client->request('GET', sprintf('%s%s', $this->path, 'resistor'));
        $link = $crawler->filter('#sort-value-up')->link();
        $crawler = $this->client->click($link);
        self::assertResponseStatusCodeSame(200);
        $components = $crawler->filter($this->tr);
        self::assertEquals('R1', $components->first()->filter('td')->first()->text());
    }

    public function testSortDown()
    {
        $crawler = $this->client->request('GET', sprintf('%s%s', $this->path, 'resistor'));
        $link = $crawler->filter('#sort-value-down')->link();
        $crawler = $this->client->click($link);
        self::assertResponseStatusCodeSame(200);
        $components = $crawler->filter($this->tr);
        self::assertEquals('R2', $components->first()->filter('td')->first()->text());

    }

    public function testFilter()
    {
        $crawler = $this->client->request('GET', sprintf('%s%s', $this->path, 'resistor'));
        $form = $crawler->selectButton('Search')->form();
        $form['field'] = 'value';
        $form['value'] = '1n';
        $crawler = $this->client->submit($form);
        self::assertResponseStatusCodeSame(200);
        self::assertCount(1, $crawler->filter($this->tr));
    }

    public function testDelete()
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());
        $fixture = $this->repository->findOneBy(['name' => 'R1']);

        $this->client->request('GET', sprintf('%sshow/%s', $this->path, $fixture->getId()));
        $this->client->submitForm('delete');

        self::assertSame($originalNumObjectsInRepository - 1, count($this->repository->findAll()));
        self::assertResponseRedirects($this->path);

    }

    protected function setUp(): void
    {
        $this->client = static::createClient();

        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Component::class);
        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->databaseTool->loadFixtures([
            TestFixtures::class
        ]);

        $userRepository = static::getContainer()->get(UserRepository::class);
        $this->user = $userRepository->findOneByEmail('user@example.com');
        $this->client->loginUser($this->user);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}
