<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Valid;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[NotBlank]
    private $name;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\OneToMany(
        mappedBy: 'project',
        targetEntity: ProjectItem::class,
        cascade: ['persist'],
        orphanRemoval: true
    )]
    #[Valid]
    private $projectItems;

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
        if ($this->projectItems->removeElement($projectItem)) {
            // set the owning side to null (unless already changed)
            if ($projectItem->getProject() === $this) {
                $projectItem->setProject(null);
            }
        }

        return $this;
    }
}
