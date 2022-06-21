<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank]
    private $name;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\OneToMany(
        mappedBy: 'project',
        targetEntity: ProjectItem::class,
        cascade: ['persist'],
        orphanRemoval: true
    )]
    #[Assert\Valid]
    private $projectItems;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    #[Blameable(on: 'create')]
    private $user;

    public function __construct()
    {
        $this->projectItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, ProjectItem>
     */
    public function getProjectItems(): Collection
    {
        return $this->projectItems;
    }

    public function addProjectItem(ProjectItem $projectItem): self
    {
        if (!$this->projectItems->contains($projectItem)) {
            $this->projectItems[] = $projectItem;
            $projectItem->setProject($this);
        }

        return $this;
    }

    public function removeProjectItem(ProjectItem $projectItem): self
    {
        if ($this->projectItems->removeElement($projectItem) & $projectItem->getProject() === $this) {
            $projectItem->setProject(null);
        }
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
