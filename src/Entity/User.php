<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"owner" = "Owner", "tenant" = "Tenant", "guaranty" = "Guaranty", "admin" = "Admin"})
 */
abstract class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     */
    private $address;

    /**
     * @ORM\OneToOne(targetEntity=Contract::class, inversedBy="tenantUser", cascade={"persist", "remove"})
     */
    private $tenantContract;

    /**
     * @ORM\OneToMany(targetEntity=Contract::class, mappedBy="ownerUser")
     */
    private $ownerContract;

    /**
     * @ORM\OneToOne(targetEntity=Contract::class, inversedBy="guarantyUser", cascade={"persist", "remove"})
     */
    private $guarantyContract;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;

    public function __construct()
    {
        $this->ownerContract = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getTenantContract(): ?Contract
    {
        return $this->tenantContract;
    }

    public function setTenantContract(?Contract $tenantContract): self
    {
        $this->tenantContract = $tenantContract;

        return $this;
    }

    /**
     * @return Collection|Contract[]
     */
    public function getOwnerContract(): Collection
    {
        return $this->ownerContract;
    }

    public function addOwnerContract(Contract $ownerContract): self
    {
        if (!$this->ownerContract->contains($ownerContract)) {
            $this->ownerContract[] = $ownerContract;
            $ownerContract->setOwnerUser($this);
        }

        return $this;
    }

    public function removeOwnerContract(Contract $ownerContract): self
    {
        if ($this->ownerContract->removeElement($ownerContract)) {
            // set the owning side to null (unless already changed)
            if ($ownerContract->getOwnerUser() === $this) {
                $ownerContract->setOwnerUser(null);
            }
        }

        return $this;
    }

    public function getGuarantyContract(): ?Contract
    {
        return $this->guarantyContract;
    }

    public function setGuarantyContract(?Contract $guarantyContract): self
    {
        $this->guarantyContract = $guarantyContract;

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

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }
}
