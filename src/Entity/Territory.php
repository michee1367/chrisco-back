<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\TerritoryRepository;
use App\State\TerritoryStateProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Asset;

#[ORM\Entity(repositoryClass: TerritoryRepository::class)]
#[
    ApiResource(
        normalizationContext:["groups" => ["territory:read", "province:read"]],
        denormalizationContext:["groups" => ["territory:write"]]
    )
]
#[Get()]
#[GetCollection(
    provider:TerritoryStateProvider::class
)]
#[Post()]
#[Patch()]
class Territory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["territory:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["territory:read", "territory:write"])]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'territories')]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    #[Groups(["territory:read", "territory:write"])]
    private ?Province $province = null;


    #[ORM\OneToMany(mappedBy: 'territory', targetEntity: Parish::class)]
    private Collection $parishes;

    #[ORM\OneToMany(mappedBy: 'territory', targetEntity: Household::class)]
    private Collection $households;

    #[ORM\OneToMany(mappedBy: 'territory', targetEntity: TerritoryPresbytery::class)]
    private Collection $territoryPresbyteries;

    public function __construct()
    {
        $this->parishes = new ArrayCollection();
        $this->households = new ArrayCollection();
        $this->territoryPresbyteries = new ArrayCollection();
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

    public function getProvince(): ?Province
    {
        return $this->province;
    }

    public function setProvince(?Province $province): self
    {
        $this->province = $province;

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
            $parish->setTerritory($this);
        }

        return $this;
    }

    public function removeParish(Parish $parish): self
    {
        if ($this->parishes->removeElement($parish)) {
            // set the owning side to null (unless already changed)
            if ($parish->getTerritory() === $this) {
                $parish->setTerritory(null);
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
            $household->setTerritory($this);
        }

        return $this;
    }

    public function removeHousehold(Household $household): self
    {
        if ($this->households->removeElement($household)) {
            // set the owning side to null (unless already changed)
            if ($household->getTerritory() === $this) {
                $household->setTerritory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TerritoryPresbytery>
     */
    public function getTerritoryPresbyteries(): Collection
    {
        return $this->territoryPresbyteries;
    }

    public function addTerritoryPresbytery(TerritoryPresbytery $territoryPresbytery): self
    {
        if (!$this->territoryPresbyteries->contains($territoryPresbytery)) {
            $this->territoryPresbyteries->add($territoryPresbytery);
            $territoryPresbytery->setTerritory($this);
        }

        return $this;
    }

    public function removeTerritoryPresbytery(TerritoryPresbytery $territoryPresbytery): self
    {
        if ($this->territoryPresbyteries->removeElement($territoryPresbytery)) {
            // set the owning side to null (unless already changed)
            if ($territoryPresbytery->getTerritory() === $this) {
                $territoryPresbytery->setTerritory(null);
            }
        }

        return $this;
    }
}
