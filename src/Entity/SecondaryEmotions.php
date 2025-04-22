<?php

namespace App\Entity;

use App\Repository\SecondaryEmotionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SecondaryEmotionsRepository::class)]
class SecondaryEmotions
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

    /**
     * @var Collection<int, EmotionTracker>
     */
    #[ORM\ManyToMany(targetEntity: EmotionTracker::class, mappedBy: 'SummedScore')]
    private Collection $EmotionTrackerId;

    public function __construct()
    {
        $this->EmotionTrackerId = new ArrayCollection();
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

    /**
     * @return Collection<int, EmotionTracker>
     */
    public function getEmotionTrackerId(): Collection
    {
        return $this->EmotionTrackerId;
    }

    public function addEmotionTrackerId(EmotionTracker $emotionTrackerId): static
    {
        if (!$this->EmotionTrackerId->contains($emotionTrackerId)) {
            $this->EmotionTrackerId->add($emotionTrackerId);
            $emotionTrackerId->addSummedScore($this);
        }

        return $this;
    }

    public function removeEmotionTrackerId(EmotionTracker $emotionTrackerId): static
    {
        if ($this->EmotionTrackerId->removeElement($emotionTrackerId)) {
            $emotionTrackerId->removeSummedScore($this);
        }

        return $this;
    }
}
