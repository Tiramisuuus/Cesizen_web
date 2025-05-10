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
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $score = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $adviceGiven = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'emotionTrackers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: SecondaryEmotions::class, inversedBy: 'emotionTrackers')]
    #[ORM\JoinTable(name: 'emotion_tracker_secondary_emotions')]
    private Collection $secondaryEmotions;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt = null;

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }


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

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(?float $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getAdviceGiven(): ?string
    {
        return $this->adviceGiven;
    }

    public function setAdviceGiven(?string $adviceGiven): self
    {
        $this->adviceGiven = $adviceGiven;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
        $this->secondaryEmotions->add($emotion);
        }

        return $this;
    }

    public function removeSecondaryEmotion(SecondaryEmotions $emotion): self
    {
        $this->secondaryEmotions->removeElement($emotion);

        return $this;
    }
}
