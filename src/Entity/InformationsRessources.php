<?php

namespace App\Entity;

use App\Repository\InformationsRessourcesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InformationsRessourcesRepository::class)]
class InformationsRessources
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

    #[ORM\ManyToOne(targetEntity: Exercises::class, inversedBy: 'informationsRessources')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Exercises $exercise = null;

    #[ORM\ManyToMany(
        targetEntity: User::class,
        mappedBy: 'favoriteResources'
    )]
    private Collection $favedByUsers;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $author = null;

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;
        return $this;
    }
    public function __construct()
    {
        $this->favedByUsers = new ArrayCollection();
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

    public function getExercise(): ?Exercises
    {
        return $this->exercise;
    }

    public function setExercise(?Exercises $exercise): self
    {
        $this->exercise = $exercise;
        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFavedByUsers(): Collection
    {
        return $this->favedByUsers;
    }

    public function addFavedByUser(User $user): self
    {
        if (!$this->favedByUsers->contains($user)) {
            $this->favedByUsers->add($user);
            $user->addFavoriteResource($this);
        }

        return $this;
    }

    public function removeFavedByUser(User $user): self
    {
        if ($this->favedByUsers->removeElement($user)) {
            $user->removeFavoriteResource($this);
        }

        return $this;
    }
}
