<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\ParishRepository;
use App\State\ParishStateProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Asset;

#[ORM\Entity(repositoryClass: ParishRepository::class)]
#[
    ApiResource(
        normalizationContext:["groups" => ["parish:read","presbytery:read"]],
        denormalizationContext:["groups" => ["parish:write"]]
    )
]
#[Get()]
#[GetCollection(
    provider:ParishStateProvider::class
)]
#[Post()]
#[Patch()]
class Parish
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["parish:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["parish:read", "parish:write"])]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'parishes')]
    #[Groups(["parish:read", "parish:write"])]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    private ?Presbytery $presbytery = null;

    #[ORM\ManyToOne(inversedBy: 'parishes')]
    #[Groups(["parish:read", "parish:write"])]
    private ?Town $town = null;

    #[ORM\ManyToOne(inversedBy: 'parishes')]
    #[Groups(["parish:read", "parish:write"])]
    private ?Territory $territory = null;

    #[ORM\Column(length: 255)]
    #[Groups(["parish:read", "parish:write"])]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    private ?string $address = null;

    #[ORM\OneToMany(mappedBy: 'parish', targetEntity: User::class)]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function getPresbytery(): ?Presbytery
    {
        return $this->presbytery;
    }

    public function setPresbytery(?Presbytery $presbytery): self
    {
        $this->presbytery = $presbytery;

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

    public function getTerritory(): ?Territory
    {
        return $this->territory;
    }

    public function setTerritory(?Territory $territory): self
    {
        $this->territory = $territory;

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

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setParish($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getParish() === $this) {
                $user->setParish(null);
            }
        }

        return $this;
    }
}
