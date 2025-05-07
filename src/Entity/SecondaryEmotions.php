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
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $score = null;

    /**
     * @var Collection<int, EmotionTracker>
     */
    #[ORM\ManyToMany(targetEntity: EmotionTracker::class, mappedBy: 'secondaryEmotions')]
    private Collection $emotionTrackers;

    #[ORM\ManyToOne(targetEntity: PrimaryEmotions::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?PrimaryEmotions $primaryEmotion = null;

    public function getPrimaryEmotion(): ?PrimaryEmotions
    {
        return $this->primaryEmotion;
    }

    public function setPrimaryEmotion(?PrimaryEmotions $primaryEmotion): self
    {
        $this->primaryEmotion = $primaryEmotion;
        return $this;
    }


    public function __construct()
    {
        $this->emotionTrackers = new ArrayCollection();
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

    /**
     * @return Collection<int, EmotionTracker>
     */
    public function getEmotionTrackers(): Collection
    {
        return $this->emotionTrackers;
    }

    public function addEmotionTracker(EmotionTracker $tracker): self
    {
        if (!$this->emotionTrackers->contains($tracker)) {
            $this->emotionTrackers->add($tracker);
            $tracker->addSecondaryEmotion($this);
        }

        return $this;
    }

    public function removeEmotionTracker(EmotionTracker $tracker): self
    {
        if ($this->emotionTrackers->removeElement($tracker)) {
            $tracker->removeSecondaryEmotion($this);
        }

        return $this;
    }
}
