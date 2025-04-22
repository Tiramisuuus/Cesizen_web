<?php

namespace App\Entity;

use App\Repository\RespirationExercisesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RespirationExercisesRepository::class)]
class RespirationExercises
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $InspirationDuration = null;

    #[ORM\Column(nullable: true)]
    private ?float $ApneaDuration = null;

    #[ORM\Column(nullable: true)]
    private ?float $AirExhalationDuration = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInspirationDuration(): ?float
    {
        return $this->InspirationDuration;
    }

    public function setInspirationDuration(?float $InspirationDuration): static
    {
        $this->InspirationDuration = $InspirationDuration;

        return $this;
    }

    public function getApneaDuration(): ?float
    {
        return $this->ApneaDuration;
    }

    public function setApneaDuration(?float $ApneaDuration): static
    {
        $this->ApneaDuration = $ApneaDuration;

        return $this;
    }

    public function getAirExhalationDuration(): ?float
    {
        return $this->AirExhalationDuration;
    }

    public function setAirExhalationDuration(?float $AirExhalationDuration): static
    {
        $this->AirExhalationDuration = $AirExhalationDuration;

        return $this;
    }
}
