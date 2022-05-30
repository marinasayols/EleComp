<?php

namespace App\Entity;

use App\Repository\ProjectItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectItemRepository::class)]
class ProjectItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'projectItems')]
    #[ORM\JoinColumn(nullable: false)]
    private $projectId;

    #[ORM\ManyToOne(targetEntity: Component::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $componentId;

    #[ORM\Column(type: 'integer')]
    private $qty;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectId(): ?Project
    {
        return $this->projectId;
    }

    public function setProjectId(?Project $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    public function getComponentId(): ?Component
    {
        return $this->componentId;
    }

    public function setComponentId(?Component $componentId): self
    {
        $this->componentId = $componentId;

        return $this;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(int $qty): self
    {
        $this->qty = $qty;

        return $this;
    }
}
