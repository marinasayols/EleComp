<?php

namespace App\Entity;

use App\Repository\InductorRepository;
use App\Visitor\Visitor;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InductorRepository::class)]
class Inductor extends Component
{

    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    private $max_current;

    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    private $DC_resistance;

    public function getMaxCurrent(): ?string
    {
        return $this->max_current;
    }

    public function setMaxCurrent(string $max_current): self
    {
        $this->max_current = $max_current;

        return $this;
    }

    public function getDCResistance(): ?string
    {
        return $this->DC_resistance;
    }

    public function setDCResistance(string $DC_resistance): self
    {
        $this->DC_resistance = $DC_resistance;

        return $this;
    }

    public function accept(Visitor $visitor): void
    {
        $visitor->visitInductor($this);
    }
}
