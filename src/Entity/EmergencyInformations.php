<?php

namespace App\Entity;

use App\Repository\EmergencyInformationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

#[ORM\Entity(repositoryClass: EmergencyInformationsRepository::class)]
class EmergencyInformations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $content = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $emergencyPhoneNumber = null;

    /**
     * Utilisateurs ayant enregistré cette urgence
     *
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(
        targetEntity: User::class,
        mappedBy: 'savedEmergency'
    )]
    private Collection $savedByUsers;

    public function __construct()
    {
        $this->savedByUsers = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getEmergencyPhoneNumber(): ?string
    {
        return $this->emergencyPhoneNumber;
    }

    public function setEmergencyPhoneNumber(?string $emergencyPhoneNumber): self
    {
        $this->emergencyPhoneNumber = $emergencyPhoneNumber;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getSavedByUsers(): Collection
    {
        return $this->savedByUsers;
    }

    public function addSavedByUser(User $user): self
    {
        if (!$this->savedByUsers->contains($user)) {
            $this->savedByUsers->add($user);
            $user->addSavedEmergency($this);
        }

        return $this;
    }

    public function removeSavedByUser(User $user): self
    {
        if ($this->savedByUsers->removeElement($user)) {
            $user->removeSavedEmergency($this);
        }

        return $this;
    }
}
