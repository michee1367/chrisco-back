<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\TownRepository;
use App\State\TownStateProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Asset;

#[ORM\Entity(repositoryClass: TownRepository::class)]
#[
    ApiResource(
        normalizationContext:["groups" => ["town:read", "city:read", "province:read"]],
        denormalizationContext:["groups" => ["town:write"]]
    )
]
#[Get()]
#[GetCollection(
    provider:TownStateProvider::class
)]
#[Post()]
#[Patch()]
class Town
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["town:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["town:read", "town:write"])]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'towns')]
    #[Groups(["town:read", "town:write"])]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    private ?City $city = null;


    #[ORM\OneToMany(mappedBy: 'town', targetEntity: Parish::class)]
    private Collection $parishes;

    #[ORM\OneToMany(mappedBy: 'town', targetEntity: Household::class)]
    private Collection $households;

    #[ORM\OneToMany(mappedBy: 'town', targetEntity: TownPresbytery::class)]
    private Collection $townPresbyteries;

    public function __construct()
    {
        $this->parishes = new ArrayCollection();
        $this->households = new ArrayCollection();
        $this->townPresbyteries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }
    /**
     * @return Collection<int, Parish>
     */
    public function getParishes(): Collection
    {
        return $this->parishes;
    }

    public function addParish(Parish $parish): self
    {
        if (!$this->parishes->contains($parish)) {
            $this->parishes->add($parish);
            $parish->setTown($this);
        }

        return $this;
    }

    public function removeParish(Parish $parish): self
    {
        if ($this->parishes->removeElement($parish)) {
            // set the owning side to null (unless already changed)
            if ($parish->getTown() === $this) {
                $parish->setTown(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Household>
     */
    public function getHouseholds(): Collection
    {
        return $this->households;
    }

    public function addHousehold(Household $household): self
    {
        if (!$this->households->contains($household)) {
            $this->households->add($household);
            $household->setTown($this);
        }

        return $this;
    }

    public function removeHousehold(Household $household): self
    {
        if ($this->households->removeElement($household)) {
            // set the owning side to null (unless already changed)
            if ($household->getTown() === $this) {
                $household->setTown(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TownPresbytery>
     */
    public function getTownPresbyteries(): Collection
    {
        return $this->townPresbyteries;
    }

    public function addTownPresbytery(TownPresbytery $townPresbytery): self
    {
        if (!$this->townPresbyteries->contains($townPresbytery)) {
            $this->townPresbyteries->add($townPresbytery);
            $townPresbytery->setTown($this);
        }

        return $this;
    }

    public function removeTownPresbytery(TownPresbytery $townPresbytery): self
    {
        if ($this->townPresbyteries->removeElement($townPresbytery)) {
            // set the owning side to null (unless already changed)
            if ($townPresbytery->getTown() === $this) {
                $townPresbytery->setTown(null);
            }
        }

        return $this;
    }
}
