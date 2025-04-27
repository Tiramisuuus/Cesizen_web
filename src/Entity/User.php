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

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    /**
     * @var Collection<int, EmotionTracker>
     */
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: EmotionTracker::class, orphanRemoval: true)]
    private Collection $emotionTrackers;

    /**
     * @var Collection<int, EmergencyInformations>
     */
    #[ORM\ManyToMany(targetEntity: EmergencyInformations::class)]
    #[ORM\JoinTable(name: 'user_saved_emergency')]
    private Collection $savedEmergency;

    /**
     * @var Collection<int, InformationsRessources>
     */
    #[ORM\ManyToMany(targetEntity: InformationsRessources::class)]
    #[ORM\JoinTable(name: 'user_favorite_resources')]
    private Collection $favoriteResources;

    public function __construct()
    {
        $this->emotionTrackers      = new ArrayCollection();
        $this->savedEmergency       = new ArrayCollection();
        $this->favoriteResources     = new ArrayCollection();
        $this->createdAt            = new \DateTime();
        $this->isActive             = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): static
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Retourne le rôle sous forme d'un tableau pour Symfony
     */
    public function getRoles(): array
    {
        return [$this->role];
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = strtoupper($role);
        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return Collection<int, EmotionTracker>
     */
    public function getEmotionTrackers(): Collection
    {
        return $this->emotionTrackers;
    }

    public function addEmotionTracker(EmotionTracker $tracker): static
    {
        if (!$this->emotionTrackers->contains($tracker)) {
            $this->emotionTrackers->add($tracker);
            $tracker->setUser($this);
        }
        return $this;
    }

    public function removeEmotionTracker(EmotionTracker $tracker): static
    {
        if ($this->emotionTrackers->removeElement($tracker)) {
            if ($tracker->getUser() === $this) {
                $tracker->setUser(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, EmergencyInformations>
     */
    public function getSavedEmergency(): Collection
    {
        return $this->savedEmergency;
    }

    public function addSavedEmergency(EmergencyInformations $info): static
    {
        if (!$this->savedEmergency->contains($info)) {
            $this->savedEmergency->add($info);
        }
        return $this;
    }

    public function removeSavedEmergency(EmergencyInformations $info): static
    {
        $this->savedEmergency->removeElement($info);
        return $this;
    }

    /**
     * @return Collection<int, InformationsRessources>
     */
    public function getFavoriteResources(): Collection
    {
        return $this->favoriteResources;
    }

    public function addFavoriteResource(InformationsRessources $res): static
    {
        if (!$this->favoriteResources->contains($res)) {
            $this->favoriteResources->add($res);
        }
        return $this;
    }

    public function removeFavoriteResource(InformationsRessources $res): static
    {
        $this->favoriteResources->removeElement($res);
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        // Si vous aviez des champs temporaires, les nettoyer ici.
    }
}
