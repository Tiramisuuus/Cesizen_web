<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $email;

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $username = null;

    #[ORM\Column(type: 'string', length: 20)]
    private string $role = 'ROLE_USER';

    #[ORM\Column(type: 'boolean')]
    private bool $isActive = true;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: EmotionTracker::class, orphanRemoval: true)]
    private Collection $emotionTrackers;

    #[ORM\ManyToMany(
        targetEntity: EmergencyInformations::class,
        inversedBy: 'savedByUsers'
    )]
    #[ORM\JoinTable(name: 'user_saved_emergency')]
    private Collection $savedEmergency;

    #[ORM\ManyToMany(
        targetEntity: InformationsRessources::class,
        inversedBy: 'favedByUsers'
    )]
    #[ORM\JoinTable(name: 'user_favorite_resources')]
    private Collection $favoriteResources;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $token = null;

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function __construct()
    {
        $this->emotionTrackers   = new ArrayCollection();
        $this->savedEmergency    = new ArrayCollection();
        $this->favoriteResources = new ArrayCollection();
        $this->createdAt         = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getRoles(): array
    {
        return [$this->role];
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = strtoupper($role);
        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getEmotionTrackers(): Collection
    {
        return $this->emotionTrackers;
    }

    public function addEmotionTracker(EmotionTracker $tracker): self
    {
        if (!$this->emotionTrackers->contains($tracker)) {
            $this->emotionTrackers->add($tracker);
            $tracker->setUser($this);
        }
        return $this;
    }

    public function removeEmotionTracker(EmotionTracker $tracker): self
    {
        if ($this->emotionTrackers->removeElement($tracker)) {
            if ($tracker->getUser() === $this) {
                $tracker->setUser(null);
            }
        }
        return $this;
    }

    public function getSavedEmergency(): Collection
    {
        return $this->savedEmergency;
    }

    public function addSavedEmergency(EmergencyInformations $info): self
    {
        if (!$this->savedEmergency->contains($info)) {
            $this->savedEmergency->add($info);
        }
        return $this;
    }

    public function removeSavedEmergency(EmergencyInformations $info): self
    {
        $this->savedEmergency->removeElement($info);
        return $this;
    }

    public function getFavoriteResources(): Collection
    {
        return $this->favoriteResources;
    }

    public function addFavoriteResource(InformationsRessources $res): self
    {
        if (!$this->favoriteResources->contains($res)) {
            $this->favoriteResources->add($res);
        }
        return $this;
    }

    public function removeFavoriteResource(InformationsRessources $res): self
    {
        $this->favoriteResources->removeElement($res);
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Clear temporary data if any
    }
}
