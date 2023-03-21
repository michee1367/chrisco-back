<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\UserRepository;
use App\State\MemberStateProvider;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints as Asset;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[
    ApiResource(
        normalizationContext:["groups" => ["member:read", "parish:read","town:read", "city:read", "province:read","territory:read","presbytery:read"]],
        denormalizationContext:["groups" => ["member:write"]]
    )
]
#[Get()]
#[GetCollection(
    provider:MemberStateProvider::class
)]
#[Post()]
#[Patch()]
class User
{
    Const SEXE_MALE="M";
    Const SEXE_FEMALE="F";
    Const SEXES=[self::SEXE_MALE, self::SEXE_FEMALE];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["member:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["member:read", "member:write"])]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["member:read", "member:write"])]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(["member:read", "member:write"])]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Groups(["member:read", "member:write"])]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    #[Choice(choices:self::SEXES)]
    private ?string $sexe = null;

    #[ORM\Column(length: 255)]
    #[Groups(["member:read", "member:write"])]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["member:read", "member:write"])]
    private ?string $whatsappPhoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["member:read", "member:write"])]
    #[Asset\Email()]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[Groups(["member:read", "member:write"])]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    private ?Parish $parish = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["member:read", "member:write"])]
    #[Asset\NotBlank()]
    #[Asset\NotNull()]
    private ?string $address = null;

    #[ORM\ManyToOne(inversedBy: 'members')]
    #[Groups(["member:read", "member:write"])]
    private ?Territory $territory = null;

    #[ORM\ManyToOne(inversedBy: 'members')]
    #[Groups(["member:read", "member:write"])]
    private ?Town $town = null;

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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getWhatsappPhoneNumber(): ?string
    {
        return $this->whatsappPhoneNumber;
    }

    public function setWhatsappPhoneNumber(?string $whatsappPhoneNumber): self
    {
        $this->whatsappPhoneNumber = $whatsappPhoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getParish(): ?Parish
    {
        return $this->parish;
    }

    public function setParish(?Parish $parish): self
    {
        $this->parish = $parish;

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
}
