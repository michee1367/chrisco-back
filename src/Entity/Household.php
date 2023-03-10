<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\HouseholdRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Asset;

#[ORM\Entity(repositoryClass: HouseholdRepository::class)]
#[ApiResource]
class Household
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'households')]
    private ?Territory $territory = null;

    #[ORM\ManyToOne(inversedBy: 'households')]
    private ?Town $town = null;

    #[ORM\Column(length: 255)]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    private ?string $address = null;

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

    public function getTerritory(): ?Territory
    {
        return $this->territory;
    }

    public function setTerritory(?Territory $territory): self
    {
        $this->territory = $territory;

        return $this;
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }
}
