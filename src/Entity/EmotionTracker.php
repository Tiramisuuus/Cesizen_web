<?php

namespace App\Entity;

use App\Repository\EmotionTrackerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmotionTrackerRepository::class)]
class EmotionTracker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(nullable: true)]
    private ?float $Score = null;

    #[ORM\Column(length: 2550)]
    private ?string $AdviceGiven = null;

    #[ORM\ManyToOne(inversedBy: 'emotionTrackers')]
    private ?User $UserId = null;

    /**
     * @var Collection<int, SecondaryEmotions>
     */
    #[ORM\ManyToMany(targetEntity: SecondaryEmotions::class, inversedBy: 'EmotionTrackerId')]
    private Collection $SummedScore;

    public function __construct()
    {
        $this->SummedScore = new ArrayCollection();
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

    public function getScore(): ?float
    {
        return $this->Score;
    }

    public function setScore(?float $Score): static
    {
        $this->Score = $Score;

        return $this;
    }

    public function getAdviceGiven(): ?string
    {
        return $this->AdviceGiven;
    }

    public function setAdviceGiven(string $AdviceGiven): static
    {
        $this->AdviceGiven = $AdviceGiven;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->UserId;
    }

    public function setUserId(?User $UserId): static
    {
        $this->UserId = $UserId;

        return $this;
    }

    /**
     * @return Collection<int, SecondaryEmotions>
     */
    public function getSummedScore(): Collection
    {
        return $this->SummedScore;
    }

    public function addSummedScore(SecondaryEmotions $summedScore): static
    {
        if (!$this->SummedScore->contains($summedScore)) {
            $this->SummedScore->add($summedScore);
        }

        return $this;
    }

    public function removeSummedScore(SecondaryEmotions $summedScore): static
    {
        $this->SummedScore->removeElement($summedScore);

        return $this;
    }
}
