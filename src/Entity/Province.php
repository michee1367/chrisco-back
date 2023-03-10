<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProvinceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Asset;

#[ORM\Entity(repositoryClass: ProvinceRepository::class)]
#[ApiResource(
    normalizationContext:["groups" => ["province:read"]],
    denormalizationContext:["groups" => ["province:write"]]
)]
class Province
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["province:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    #[Groups(["province:read","province:write"])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'province', targetEntity: Territory::class)]
    private Collection $territories;

    #[ORM\OneToMany(mappedBy: 'province', targetEntity: City::class)]
    private Collection $cities;

    public function __construct()
    {
        $this->territories = new ArrayCollection();
        $this->cities = new ArrayCollection();
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

    /**
     * @return Collection<int, Territory>
     */
    public function getTerritories(): Collection
    {
        return $this->territories;
    }

    public function addTerritory(Territory $territory): self
    {
        if (!$this->territories->contains($territory)) {
            $this->territories->add($territory);
            $territory->setProvince($this);
        }

        return $this;
    }

    public function removeTerritory(Territory $territory): self
    {
        if ($this->territories->removeElement($territory)) {
            // set the owning side to null (unless already changed)
            if ($territory->getProvince() === $this) {
                $territory->setProvince(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, City>
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): self
    {
        if (!$this->cities->contains($city)) {
            $this->cities->add($city);
            $city->setProvince($this);
        }

        return $this;
    }

    public function removeCity(City $city): self
    {
        if ($this->cities->removeElement($city)) {
            // set the owning side to null (unless already changed)
            if ($city->getProvince() === $this) {
                $city->setProvince(null);
            }
        }

        return $this;
    }
}
