<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TerritoryPresbyteryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Asset;

#[ORM\Entity(repositoryClass: TerritoryPresbyteryRepository::class)]
#[ApiResource(
    normalizationContext:["groups" => ["presbytery:read","territory:read"]],
    denormalizationContext:["groups" => ["presbytery:write"]]
)]
#[UniqueEntity(
    fields:["presbytery","territory"]
)]
class TerritoryPresbytery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["presbytery:read"])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'territoryPresbyteries')]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    #[Groups(["presbytery:read", "presbytery:write"])]
    private ?Presbytery $presbytery = null;

    #[ORM\ManyToOne(inversedBy: 'territoryPresbyteries')]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    #[Groups(["presbytery:read", "presbytery:write"])]
    private ?Territory $territory = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresbytery(): ?Presbytery
    {
        return $this->presbytery;
    }

    public function setPresbytery(?Presbytery $presbytery): self
    {
        $this->presbytery = $presbytery;

        return $this;
    }

    public function getTerritory(): ?Territory
    {
        return $this->territory;
    }

    public function setTerritory(?Territory $territory): self
    {
        $this->territory = $territory;

        return $this;
    }
}
