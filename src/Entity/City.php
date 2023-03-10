<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\CityRepository;
use App\State\CityStateProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Asset;

#[ORM\Entity(repositoryClass: CityRepository::class)]
#[
    ApiResource(
        normalizationContext:["groups" => ["city:read", "province:read"]],
        denormalizationContext:["groups" => ["city:write"]]
    )
]
#[Get()]
#[GetCollection(
    provider:CityStateProvider::class
)]
#[Patch()]
#[Post()]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["city:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["city:read","city:write"])]
    #[Asset\NotNull()]
    #[Asset\NotBlank()]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'cities')]
    #[Groups(["city:read", "city:write"])]
    #[Asset\NotNull()]
    #[Asset\NotBlank()]
    private ?Province $province = null;

    #[ORM\OneToMany(mappedBy: 'city', targetEntity: Town::class)]
    private Collection $towns;

    public function __construct()
    {
        $this->towns = new ArrayCollection();
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
     * @return Collection<int, Town>
     */
    public function getTowns(): Collection
    {
        return $this->towns;
    }

    public function addTown(Town $town): self
    {
        if (!$this->towns->contains($town)) {
            $this->towns->add($town);
            $town->setCity($this);
        }

        return $this;
    }

    public function removeTown(Town $town): self
    {
        if ($this->towns->removeElement($town)) {
            // set the owning side to null (unless already changed)
            if ($town->getCity() === $this) {
                $town->setCity(null);
            }
        }

        return $this;
    }
}
