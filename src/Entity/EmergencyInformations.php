<?php

namespace App\Entity;

use App\Repository\EmergencyInformationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmergencyInformationsRepository::class)]
class EmergencyInformations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(length: 2550, nullable: true)]
    private ?string $Content = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $EmergencyPhoneNumber = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'Saved')]
    private Collection $SavedByUserId;

    public function __construct()
    {
        $this->SavedByUserId = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(?string $Content): static
    {
        $this->Content = $Content;

        return $this;
    }

    public function getEmergencyPhoneNumber(): ?string
    {
        return $this->EmergencyPhoneNumber;
    }

    public function setEmergencyPhoneNumber(?string $EmergencyPhoneNumber): static
    {
        $this->EmergencyPhoneNumber = $EmergencyPhoneNumber;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getSavedByUserId(): Collection
    {
        return $this->SavedByUserId;
    }

    public function addSavedByUserId(User $savedByUserId): static
    {
        if (!$this->SavedByUserId->contains($savedByUserId)) {
            $this->SavedByUserId->add($savedByUserId);
            $savedByUserId->addSaved($this);
        }

        return $this;
    }

    public function removeSavedByUserId(User $savedByUserId): static
    {
        if ($this->SavedByUserId->removeElement($savedByUserId)) {
            $savedByUserId->removeSaved($this);
        }

        return $this;
    }
}
