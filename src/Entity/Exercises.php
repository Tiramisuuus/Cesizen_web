<?php

namespace App\Entity;

use App\Repository\ExercisesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExercisesRepository::class)]
class Exercises
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $CreationDate = null;

    /**
     * @var Collection<int, InformationsRessources>
     */
    #[ORM\OneToMany(targetEntity: InformationsRessources::class, mappedBy: 'ExerciceId')]
    private Collection $informationsRessources;

    /**
     * @var Collection<int, StressDiagnosticResult>
     */
    #[ORM\ManyToMany(targetEntity: StressDiagnosticResult::class, inversedBy: 'ExerciseId')]
    private Collection $RecommendedExercises;

    public function __construct()
    {
        $this->informationsRessources = new ArrayCollection();
        $this->RecommendedExercises = new ArrayCollection();
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

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->CreationDate;
    }

    public function setCreationDate(?\DateTimeInterface $CreationDate): static
    {
        $this->CreationDate = $CreationDate;

        return $this;
    }

    /**
     * @return Collection<int, InformationsRessources>
     */
    public function getInformationsRessources(): Collection
    {
        return $this->informationsRessources;
    }

    public function addInformationsRessource(InformationsRessources $informationsRessource): static
    {
        if (!$this->informationsRessources->contains($informationsRessource)) {
            $this->informationsRessources->add($informationsRessource);
            $informationsRessource->setExerciceId($this);
        }

        return $this;
    }

    public function removeInformationsRessource(InformationsRessources $informationsRessource): static
    {
        if ($this->informationsRessources->removeElement($informationsRessource)) {
            // set the owning side to null (unless already changed)
            if ($informationsRessource->getExerciceId() === $this) {
                $informationsRessource->setExerciceId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StressDiagnosticResult>
     */
    public function getRecommendedExercises(): Collection
    {
        return $this->RecommendedExercises;
    }

    public function addRecommendedExercise(StressDiagnosticResult $recommendedExercise): static
    {
        if (!$this->RecommendedExercises->contains($recommendedExercise)) {
            $this->RecommendedExercises->add($recommendedExercise);
        }

        return $this;
    }

    public function removeRecommendedExercise(StressDiagnosticResult $recommendedExercise): static
    {
        $this->RecommendedExercises->removeElement($recommendedExercise);

        return $this;
    }
}
