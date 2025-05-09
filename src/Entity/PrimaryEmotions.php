<?php

namespace App\Entity;

use App\Repository\PrimaryEmotionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\SecondaryEmotions;

#[ORM\Entity(repositoryClass: PrimaryEmotionsRepository::class)]
class PrimaryEmotions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'primaryEmotion', targetEntity: SecondaryEmotions::class, cascade: ['persist', 'remove'])]
    private Collection $secondaryEmotions;

    public function __construct()
    {
        $this->secondaryEmotions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Collection<int, SecondaryEmotions>
     */
    public function getSecondaryEmotions(): Collection
    {
        return $this->secondaryEmotions;
    }

    public function addSecondaryEmotion(SecondaryEmotions $emotion): self
    {
        if (!$this->secondaryEmotions->contains($emotion)) {
            $this->secondaryEmotions[] = $emotion;
            $emotion->setPrimaryEmotion($this);
        }

        return $this;
    }

    public function removeSecondaryEmotion(SecondaryEmotions $emotion): self
    {
        if ($this->secondaryEmotions->removeElement($emotion)) {
            if ($emotion->getPrimaryEmotion() === $this) {
                $emotion->setPrimaryEmotion(null);
            }
        }

        return $this;
    }
}
