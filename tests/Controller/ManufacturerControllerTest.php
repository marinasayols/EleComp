<?php

namespace App\Tests\Controller;

use App\Entity\Manufacturer;
use App\Entity\User;
use App\Repository\ManufacturerRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ManufacturerControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ManufacturerRepository $repository;
    private string $path = '/manufacturer/';
    private string $title = 'My title';
    private string $new = 'Something new';
    private User $user;

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Manufacturer index');
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'manufacturer[name]' => 'Testing',
            'manufacturer[website]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $fixture = new Manufacturer();
        $fixture->setName($this->title);
        $fixture->setWebsite($this->title);
        $fixture->setUser($this->user);

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Manufacturer');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $fixture = new Manufacturer();
        $fixture->setName($this->title);
        $fixture->setWebsite($this->title);
        $fixture->setUser($this->user);

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'manufacturer[name]' => $this->new,
            'manufacturer[website]' => $this->new,
        ]);

        self::assertResponseRedirects($this->path);

        $fixture = $this->repository->findAll();

        self::assertSame($this->new, $fixture[0]->getName());
        self::assertSame($this->new, $fixture[0]->getWebsite());
    }

    public function testRemove(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Manufacturer();
        $fixture->setName($this->title);
        $fixture->setWebsite($this->title);
        $fixture->setUser($this->user);

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects($this->path);
    }

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Manufacturer::class);

        $userRepository = static::getContainer()->get(UserRepository::class);
        $this->user = $userRepository->findOneByEmail('user@example.com');
        $this->client->loginUser($this->user);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }
}
