<?php

namespace App\Entity;

use App\Repository\StressDiagnosticRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StressDiagnosticRepository::class)]
class StressDiagnostic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateRealisation = null;

    #[ORM\Column(nullable: true)]
    private ?float $Score = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $UserId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(?string $Title): static
    {
        $this->Title = $Title;

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

    public function getDateRealisation(): ?\DateTimeInterface
    {
        return $this->DateRealisation;
    }

    public function setDateRealisation(\DateTimeInterface $DateRealisation): static
    {
        $this->DateRealisation = $DateRealisation;

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

    public function getUserId(): ?User
    {
        return $this->UserId;
    }

    public function setUserId(?User $UserId): static
    {
        $this->UserId = $UserId;

        return $this;
    }
}
