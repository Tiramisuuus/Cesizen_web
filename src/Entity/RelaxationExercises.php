<?php

namespace App\Entity;

use App\Repository\RelaxationExercisesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RelaxationExercisesRepository::class)]
class RelaxationExercises
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Position = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $AudioFile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosition(): ?string
    {
        return $this->Position;
    }

    public function setPosition(?string $Position): static
    {
        $this->Position = $Position;

        return $this;
    }

    public function getAudioFile()
    {
        return $this->AudioFile;
    }

    public function setAudioFile($AudioFile): static
    {
        $this->AudioFile = $AudioFile;

        return $this;
    }
}
