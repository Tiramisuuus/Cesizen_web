<?php

namespace App\Entity;

use App\Repository\StressDiagnosticResultRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StressDiagnosticResultRepository::class)]
class StressDiagnosticResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionResult = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $recommendations = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateRealisation = null;

    #[ORM\OneToOne(
        targetEntity: StressDiagnostic::class,
        inversedBy: 'result',
        cascade: ['persist', 'remove']
    )]
    #[ORM\JoinColumn(nullable: false)]
    private ?StressDiagnostic $diagnostic = null;

    #[ORM\ManyToMany(
        targetEntity: Exercises::class,
        mappedBy: 'recommendedExercises'
    )]
    private Collection $exercises;

    public function __construct()
    {
        $this->exercises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescriptionResult(): ?string
    {
        return $this->descriptionResult;
    }

    public function setDescriptionResult(?string $descriptionResult): self
    {
        $this->descriptionResult = $descriptionResult;
        return $this;
    }

    public function getRecommendations(): ?string
    {
        return $this->recommendations;
    }

    public function setRecommendations(?string $recommendations): self
    {
        $this->recommendations = $recommendations;
        return $this;
    }

    public function getDateRealisation(): ?\DateTimeInterface
    {
        return $this->dateRealisation;
    }

    public function setDateRealisation(?\DateTimeInterface $dateRealisation): self
    {
        $this->dateRealisation = $dateRealisation;
        return $this;
    }

    public function getDiagnostic(): ?StressDiagnostic
    {
        return $this->diagnostic;
    }

    public function setDiagnostic(StressDiagnostic $diagnostic): self
    {
        $this->diagnostic = $diagnostic;
        return $this;
    }

    /**
     * @return Collection<int, Exercises>
     */
    public function getExercises(): Collection
    {
        return $this->exercises;
    }

    public function addExercise(Exercises $exercise): self
    {
        if (!$this->exercises->contains($exercise)) {
            $this->exercises->add($exercise);
            $exercise->addRecommendedExercise($this);
        }
        return $this;
    }

    public function removeExercise(Exercises $exercise): self
    {
        if ($this->exercises->removeElement($exercise)) {
            $exercise->removeRecommendedExercise($this);
        }
        return $this;
    }
}
