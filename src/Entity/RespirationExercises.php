<?php

namespace App\Entity;

use App\Repository\RespirationExercisesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RespirationExercisesRepository::class)]
class RespirationExercises
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $inspirationDuration = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $apneaDuration = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $airExhalationDuration = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInspirationDuration(): ?float
    {
        return $this->inspirationDuration;
    }

    public function setInspirationDuration(?float $inspirationDuration): self
    {
        $this->inspirationDuration = $inspirationDuration;

        return $this;
    }

    public function getApneaDuration(): ?float
    {
        return $this->apneaDuration;
    }

    public function setApneaDuration(?float $apneaDuration): self
    {
        $this->apneaDuration = $apneaDuration;

        return $this;
    }

    public function getAirExhalationDuration(): ?float
    {
        return $this->airExhalationDuration;
    }

    public function setAirExhalationDuration(?float $airExhalationDuration): self
    {
        $this->airExhalationDuration = $airExhalationDuration;

        return $this;
    }
}
