<?php

namespace App\Entity;

use App\Repository\InformationsRessourcesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InformationsRessourcesRepository::class)]
class InformationsRessources
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(length: 2550, nullable: true)]
    private ?string $Content = null;

    #[ORM\ManyToOne(inversedBy: 'informationsRessources')]
    private ?Exercises $ExerciceId = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'Favorite')]
    private Collection $faveByUserId;

    public function __construct()
    {
        $this->faveByUserId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(?string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(?string $Content): static
    {
        $this->Content = $Content;

        return $this;
    }

    public function getExerciceId(): ?Exercises
    {
        return $this->ExerciceId;
    }

    public function setExerciceId(?Exercises $ExerciceId): static
    {
        $this->ExerciceId = $ExerciceId;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFaveByUserId(): Collection
    {
        return $this->faveByUserId;
    }

    public function addFaveByUserId(User $faveByUserId): static
    {
        if (!$this->faveByUserId->contains($faveByUserId)) {
            $this->faveByUserId->add($faveByUserId);
            $faveByUserId->addFavorite($this);
        }

        return $this;
    }

    public function removeFaveByUserId(User $faveByUserId): static
    {
        if ($this->faveByUserId->removeElement($faveByUserId)) {
            $faveByUserId->removeFavorite($this);
        }

        return $this;
    }
}
