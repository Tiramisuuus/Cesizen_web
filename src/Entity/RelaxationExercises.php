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
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $position = null;

    /**
     * Stockage en Blob (audio)
     */
    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $audioFile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): static
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Retourne le contenu brut du BLOB (ressource ou string)
     */
    public function getAudioFile()
    {
        return $this->audioFile;
    }

    /**
     * Reçoit une ressource ou une string brute pour le BLOB
     */
    public function setAudioFile($audioFile): static
    {
        $this->audioFile = $audioFile;

        return $this;
    }
}
