<?php
namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;

#[ORM\Entity(repositoryClass: RaceRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(security: "is_granted('ROLE_ADMIN')"),
        new Put(security: "is_granted('ROLE_ADMIN')"),
        new Delete(security: "is_granted('ROLE_ADMIN')")
    ],
    normalizationContext: ['groups' => ['race:read']],
    denormalizationContext: ['groups' => ['race:write']]
)]
class Race
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: TypeAnimal::class, inversedBy: 'races')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeAnimal $typeAnimal = null;

    #[ORM\OneToMany(mappedBy: 'race', targetEntity: Animal::class)]
    private Collection $animaux;

    public function __construct()
    {
        $this->animaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getTypeAnimal(): ?TypeAnimal
    {
        return $this->typeAnimal;
    }

    public function setTypeAnimal(?TypeAnimal $typeAnimal): static
    {
        $this->typeAnimal = $typeAnimal;
        return $this;
    }

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimaux(): Collection
    {
        return $this->animaux;
    }

    public function addAnimal(Animal $animal): static
    {
        if (!$this->animaux->contains($animal)) {
            $this->animaux->add($animal);
            $animal->setRace($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): static
    {
        if ($this->animaux->removeElement($animal)) {
            if ($animal->getRace() === $this) {
                $animal->setRace(null);
            }
        }

        return $this;
    }
}