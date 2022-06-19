<?php

namespace App\Tests\Controller;

use App\DataFixtures\TestFixtures;
use App\Entity\Provider;
use App\Entity\User;
use App\Repository\ProviderRepository;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProviderControllerTest extends WebTestCase
{
    protected $databaseTool;
    private KernelBrowser $client;
    private ProviderRepository $repository;
    private string $path = '/provider/';
    private string $title = 'My Title';
    private string $new = 'Something new';
    private User $user;

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Provider index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'provider[name]' => 'Testing',
            'provider[phone]' => 111111111,
            'provider[email]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $fixture = new Provider();
        $fixture->setName($this->title);
        $fixture->setPhone(111111111);
        $fixture->setEmail($this->title);
        $fixture->setUser($this->user);

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Provider');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $fixture = new Provider();
        $fixture->setName($this->title);
        $fixture->setPhone(111111111);
        $fixture->setEmail($this->title);
        $fixture->setUser($this->user);

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'provider[name]' => $this->new,
            'provider[phone]' => 222222222,
            'provider[email]' => $this->new,
        ]);

        self::assertResponseRedirects($this->path);

        $fixture = $this->repository->findAll();

        self::assertSame($this->new, $fixture[0]->getName());
        self::assertSame(222222222, $fixture[0]->getPhone());
        self::assertSame($this->new, $fixture[0]->getEmail());
    }

    public function testRemove(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Provider();
        $fixture->setName($this->title);
        $fixture->setPhone(111111111);
        $fixture->setEmail($this->title);
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

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->databaseTool->loadFixtures([TestFixtures::class]);

        $userRepository = static::getContainer()->get(UserRepository::class);
        $this->user = $userRepository->findOneByEmail('user@example.com');
        $this->client->loginUser($this->user);

        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Provider::class);
        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}
