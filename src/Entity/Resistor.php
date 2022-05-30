<?php

namespace App\Entity;

use App\Repository\ResistorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResistorRepository::class)]
class Resistor extends Component
{
    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    private $power;

    #[ORM\Column(type: 'string', length: 10)]
    private $package;

    public function getPower(): ?string
    {
        return $this->power;
    }

    public function setPower(string $power): self
    {
        $this->power = $power;

        return $this;
    }

    public function getPackage(): ?string
    {
        return $this->package;
    }

    public function setPackage(string $package): self
    {
        $this->package = $package;

        return $this;
    }
}
