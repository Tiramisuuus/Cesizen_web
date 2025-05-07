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
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\OneToMany(
        mappedBy: 'exercise',
        targetEntity: InformationsRessources::class,
        cascade: ['persist', 'remove']
    )]
    private Collection $informationsRessources;

    #[ORM\ManyToMany(
        targetEntity: StressDiagnosticResult::class,
        inversedBy: 'recommendedExercises'
    )]
    #[ORM\JoinTable(name: 'exercise_recommendation')]
    private Collection $recommendedExercises;

    public function __construct()
    {
        $this->informationsRessources = new ArrayCollection();
        $this->recommendedExercises   = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(?\DateTimeInterface $creationDate): static
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * @return Collection<int, InformationsRessources>
     */
    public function getInformationsRessources(): Collection
    {
        return $this->informationsRessources;
    }

    public function addInformationsRessource(InformationsRessources $info): static
    {
        if (!$this->informationsRessources->contains($info)) {
            $this->informationsRessources->add($info);
            $info->setExercise($this);
        }

        return $this;
    }

    public function removeInformationsRessource(InformationsRessources $info): static
    {
        if ($this->informationsRessources->removeElement($info)) {
            if ($info->getExercise() === $this) {
                $info->setExercise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StressDiagnosticResult>
     */
    public function getRecommendedExercises(): Collection
    {
        return $this->recommendedExercises;
    }

    public function addRecommendedExercise(StressDiagnosticResult $result): static
    {
        if (!$this->recommendedExercises->contains($result)) {
            $this->recommendedExercises->add($result);
        }

        return $this;
    }

    public function removeRecommendedExercise(StressDiagnosticResult $result): static
    {
        $this->recommendedExercises->removeElement($result);
        return $this;
    }
}
