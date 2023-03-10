<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PresbyteryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Asset;

#[ORM\Entity(repositoryClass: PresbyteryRepository::class)]
#[ApiResource(
    normalizationContext:["groups" => ["presbytery:read"]],
    denormalizationContext:["groups" => ["presbytery:write"]]
)]
class Presbytery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["presbytery:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    #[Groups(["presbytery:read", "presbytery:write"])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'presbytery', targetEntity: Parish::class)]
    private Collection $parishes;

    #[ORM\OneToMany(mappedBy: 'presbytery', targetEntity: TerritoryPresbytery::class)]
    #[Groups(["presbytery:read"])]
    private Collection $territoryPresbyteries;

    #[ORM\OneToMany(mappedBy: 'presbytery', targetEntity: TownPresbytery::class)]
    #[Groups(["presbytery:read"])]
    private Collection $townPresbyteries;

    public function __construct()
    {
        $this->parishes = new ArrayCollection();
        $this->territoryPresbyteries = new ArrayCollection();
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

    public function setName(?string $name): self
    {
        $this->name = $name;

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
            $parish->setPresbytery($this);
        }

        return $this;
    }

    public function removeParish(Parish $parish): self
    {
        if ($this->parishes->removeElement($parish)) {
            // set the owning side to null (unless already changed)
            if ($parish->getPresbytery() === $this) {
                $parish->setPresbytery(null);
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
            $territoryPresbytery->setPresbytery($this);
        }

        return $this;
    }

    public function removeTerritoryPresbytery(TerritoryPresbytery $territoryPresbytery): self
    {
        if ($this->territoryPresbyteries->removeElement($territoryPresbytery)) {
            // set the owning side to null (unless already changed)
            if ($territoryPresbytery->getPresbytery() === $this) {
                $territoryPresbytery->setPresbytery(null);
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
            $townPresbytery->setPresbytery($this);
        }

        return $this;
    }

    public function removeTownPresbytery(TownPresbytery $townPresbytery): self
    {
        if ($this->townPresbyteries->removeElement($townPresbytery)) {
            // set the owning side to null (unless already changed)
            if ($townPresbytery->getPresbytery() === $this) {
                $townPresbytery->setPresbytery(null);
            }
        }

        return $this;
    }
}
