<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface

{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $Password = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $CreationDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Name = null;

    #[ORM\Column]
    private ?bool $IsActive = null;

    /**
     * @var Collection<int, EmotionTracker>
     */
    #[ORM\OneToMany(targetEntity: EmotionTracker::class, mappedBy: 'UserId')]
    private Collection $emotionTrackers;

    /**
     * @var Collection<int, EmergencyInformations>
     */
    #[ORM\ManyToMany(targetEntity: EmergencyInformations::class, inversedBy: 'SavedByUserId')]
    private Collection $Saved;

    /**
     * @var Collection<int, InformationsRessources>
     */
    #[ORM\ManyToMany(targetEntity: InformationsRessources::class, inversedBy: 'faveByUserId')]
    private Collection $Favorite;

    public function __construct()
    {
        $this->emotionTrackers = new ArrayCollection();
        $this->Saved = new ArrayCollection();
        $this->Favorite = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): static
    {
        $this->Password = $Password;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->CreationDate;
    }

    public function setCreationDate(\DateTimeInterface $CreationDate): static
    {
        $this->CreationDate = $CreationDate;

        return $this;
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

    public function isActive(): ?bool
    {
        return $this->IsActive;
    }

    public function setIsActive(bool $IsActive): static
    {
        $this->IsActive = $IsActive;

        return $this;
    }

    /**
     * @return Collection<int, EmotionTracker>
     */
    public function getEmotionTrackers(): Collection
    {
        return $this->emotionTrackers;
    }

    public function addEmotionTracker(EmotionTracker $emotionTracker): static
    {
        if (!$this->emotionTrackers->contains($emotionTracker)) {
            $this->emotionTrackers->add($emotionTracker);
            $emotionTracker->setUserId($this);
        }

        return $this;
    }

    public function removeEmotionTracker(EmotionTracker $emotionTracker): static
    {
        if ($this->emotionTrackers->removeElement($emotionTracker)) {
            // set the owning side to null (unless already changed)
            if ($emotionTracker->getUserId() === $this) {
                $emotionTracker->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EmergencyInformations>
     */
    public function getSaved(): Collection
    {
        return $this->Saved;
    }

    public function addSaved(EmergencyInformations $saved): static
    {
        if (!$this->Saved->contains($saved)) {
            $this->Saved->add($saved);
        }

        return $this;
    }

    public function removeSaved(EmergencyInformations $saved): static
    {
        $this->Saved->removeElement($saved);

        return $this;
    }

    /**
     * @return Collection<int, InformationsRessources>
     */
    public function getFavorite(): Collection
    {
        return $this->Favorite;
    }

    public function addFavorite(InformationsRessources $favorite): static
    {
        if (!$this->Favorite->contains($favorite)) {
            $this->Favorite->add($favorite);
        }

        return $this;
    }

    public function removeFavorite(InformationsRessources $favorite): static
    {
        $this->Favorite->removeElement($favorite);

        return $this;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }

    public function eraseCredentials(): void
    {
    }

}
