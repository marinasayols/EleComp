<?php

namespace App\Entity;

use App\Repository\ComponentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComponentRepository::class)]
class Component
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 20)]
    private $value;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $tolerance;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 3, nullable: true)]
    private $price;

    #[ORM\ManyToMany(targetEntity: Manufacturer::class, inversedBy: 'components')]
    private $manufacturers;

    #[ORM\ManyToMany(targetEntity: Provider::class, inversedBy: 'components')]
    private $providers;

    public function __construct()
    {
        $this->manufacturers = new ArrayCollection();
        $this->providers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, Manufacturer>
     */
    public function getManufacturers(): Collection
    {
        return $this->manufacturers;
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

    /**
     * @return Collection<int, Provider>
     */
    public function getProviders(): Collection
    {
        return $this->providers;
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
}
