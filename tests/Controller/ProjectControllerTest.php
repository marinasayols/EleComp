<?php

namespace App\Tests\Controller;

use App\DataFixtures\TestFixtures;
use App\Entity\Project;
use App\Entity\User;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProjectControllerTest extends WebTestCase
{
    protected $databaseTool;
    private KernelBrowser $client;
    private ProjectRepository $repository;
    private string $path = '/project/';
    private string $new = 'New';
    private User $user;

    public function testIndex()
    {
        $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Project index');
    }

    public function testNew()
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);
        $this->client->submitForm('Save', [
            'project[name]' => 'Testing',
            'project[description]' => 'Testing'
        ]);
        self::assertResponseRedirects($this->path);
        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $fixture = $this->repository->findOneBy(['name' => 'Test']);
        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Project');
    }

    public function testDelete()
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());
        $fixture = $this->repository->findOneBy(['name' => 'Project1']);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('delete');

        self::assertSame($originalNumObjectsInRepository - 1, count($this->repository->findAll()));
        self::assertResponseRedirects($this->path);
    }

    public function testEdit()
    {
        $fixture = $this->repository->findOneBy(['name' => 'Test']);
        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'project[name]' => $this->new,
            'project[description]' => $this->new
        ]);

        self::assertResponseRedirects($this->path);

        $fixture = $this->repository->find($fixture->getId());

        self::assertSame($this->new, $fixture->getName());
        self::assertSame($this->new, $fixture->getDescription());
    }

    protected function setUp(): void
    {
        $this->client = static::createClient();

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Project::class);
        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }

        $this->databaseTool->loadFixtures([TestFixtures::class]);

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
