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
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 2550, nullable: true)]
    private ?string $DescriptionResult = null;

    #[ORM\Column(length: 2550, nullable: true)]
    private ?string $Recommandations = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateRealisation = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?StressDiagnostic $OneToOne = null;

    /**
     * @var Collection<int, Exercises>
     */
    #[ORM\ManyToMany(targetEntity: Exercises::class, mappedBy: 'RecommendedExercises')]
    private Collection $ExerciseId;

    public function __construct()
    {
        $this->ExerciseId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescriptionResult(): ?string
    {
        return $this->DescriptionResult;
    }

    public function setDescriptionResult(?string $DescriptionResult): static
    {
        $this->DescriptionResult = $DescriptionResult;

        return $this;
    }

    public function getRecommandations(): ?string
    {
        return $this->Recommandations;
    }

    public function setRecommandations(?string $Recommandations): static
    {
        $this->Recommandations = $Recommandations;

        return $this;
    }

    public function getDateRealisation(): ?\DateTimeInterface
    {
        return $this->DateRealisation;
    }

    public function setDateRealisation(?\DateTimeInterface $DateRealisation): static
    {
        $this->DateRealisation = $DateRealisation;

        return $this;
    }

    public function getOneToOne(): ?StressDiagnostic
    {
        return $this->OneToOne;
    }

    public function setOneToOne(?StressDiagnostic $OneToOne): static
    {
        $this->OneToOne = $OneToOne;

        return $this;
    }

    /**
     * @return Collection<int, Exercises>
     */
    public function getExerciseId(): Collection
    {
        return $this->ExerciseId;
    }

    public function addExerciseId(Exercises $exerciseId): static
    {
        if (!$this->ExerciseId->contains($exerciseId)) {
            $this->ExerciseId->add($exerciseId);
            $exerciseId->addRecommendedExercise($this);
        }

        return $this;
    }

    public function removeExerciseId(Exercises $exerciseId): static
    {
        if ($this->ExerciseId->removeElement($exerciseId)) {
            $exerciseId->removeRecommendedExercise($this);
        }

        return $this;
    }
}
