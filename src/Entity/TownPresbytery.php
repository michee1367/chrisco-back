<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TownPresbyteryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Asset;

#[ORM\Entity(repositoryClass: TownPresbyteryRepository::class)]
#[ApiResource(
    normalizationContext:["groups" => ["presbytery:read", "town:read"]],
    denormalizationContext:["groups" => ["presbytery:write"]]
)]
#[
    UniqueEntity(
        fields:["town","presbytery"]
    )
]
class TownPresbytery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["presbytery:read"])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'townPresbyteries')]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    #[Groups(["presbytery:read", "presbytery:write"])]
    private ?Town $town = null;

    #[ORM\ManyToOne(inversedBy: 'townPresbyteries')]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    #[Groups(["presbytery:read","presbytery:write"])]
    private ?Presbytery $presbytery = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTown(): ?Town
    {
        return $this->town;
    }

    public function setTown(?Town $town): self
    {
        $this->town = $town;

        return $this;
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
}
