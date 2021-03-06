<?php

namespace App\Entity;

use App\Repository\ComponentRepository;
use App\Visitor\Visitor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Symfony\Component\Validator\Constraints\Valid;

#[ORM\Entity(repositoryClass: ComponentRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap([
    "resistor" => Resistor::class,
    "capacitor" => Capacitor::class,
    "inductor" => Inductor::class
])]
abstract class Component
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string')]
    private $name;

    #[ORM\Column(type: 'string', length: 20)]
    private $value;

    #[ORM\Column(type: 'integer')]
    private $tolerance;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 3)]
    private $price;

    #[ORM\ManyToMany(
        targetEntity: Manufacturer::class,
        inversedBy: 'components',
        cascade: ['persist', 'remove'])
    ]
    #[ORM\JoinColumn(nullable: false)]
    private $manufacturers;

    #[ORM\ManyToMany(
        targetEntity: Provider::class,
        inversedBy: 'components',
        cascade: ['persist', 'remove'])
    ]
    #[ORM\JoinColumn(nullable: true)]
    private $providers;

    #[ORM\OneToMany(
        mappedBy: 'component',
        targetEntity: ProjectItem::class,
        cascade: ['persist'],
        orphanRemoval: true
    )]
    #[Valid]
    private $projectItems;

    #[ORM\ManyToOne(targetEntity: User::class,
        cascade: ['persist', 'merge'],
        inversedBy: 'components')]
    #[ORM\JoinColumn(nullable: false)]
    #[Blameable(on: 'create')]
    private $user;

    public function __construct()
    {
        $this->manufacturers = new ArrayCollection();
        $this->providers = new ArrayCollection();
        $this->projectItems = new ArrayCollection();
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getTolerance(): ?int
    {
        return $this->tolerance;
    }

    public function setTolerance(?int $tolerance): self
    {
        $this->tolerance = $tolerance;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return ArrayCollection|Manufacturer[]
     */
    public function getManufacturers()
    {
        return $this->manufacturers;
    }

    /**
     * @return ArrayCollection|Provider[]
     */
    public function getProviders()
    {
        return $this->providers;
    }

    public function addManufacturer(Manufacturer $manufacturer): self
    {
        if (!$this->manufacturers->contains($manufacturer)) {
            $this->manufacturers[] = $manufacturer;
        }

        return $this;
    }

    public function removeManufacturer(Manufacturer $manufacturer): self
    {
        $this->manufacturers->removeElement($manufacturer);

        return $this;
    }

    public function addProvider(Provider $provider): self
    {
        if (!$this->providers->contains($provider)) {
            $this->providers[] = $provider;
        }

        return $this;
    }

    public function removeProvider(Provider $provider): self
    {
        $this->providers->removeElement($provider);

        return $this;
    }

    abstract public function accept(Visitor $visitor);

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
            $projectItem->setComponent($this);
        }

        return $this;
    }

    public function removeProjectItem(ProjectItem $projectItem): self
    {
        if ($this->projectItems->removeElement($projectItem) & $projectItem->getComponent() === $this) {
            $projectItem->setComponent(null);
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
