<?php

namespace App\Entity;

use App\Repository\CapacitorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CapacitorRepository::class)]
class Capacitor extends Component
{
    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    private $voltage;

    #[ORM\Column(type: 'string', length: 20)]
    private $temperature_coefficient;

    public function getVoltage(): ?string
    {
        return $this->voltage;
    }

    public function setVoltage(string $voltage): self
    {
        $this->voltage = $voltage;

        return $this;
    }

    public function getTemperatureCoefficient(): ?string
    {
        return $this->temperature_coefficient;
    }

    public function setTemperatureCoefficient(string $temperature_coefficient): self
    {
        $this->temperature_coefficient = $temperature_coefficient;

        return $this;
    }
}
