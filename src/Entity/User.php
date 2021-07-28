<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Assert\NotNull(message="can not be null :/")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=180)
     * 
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=180)
     * 
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=15)
     * 
     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $phone;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     */
    private $address;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     */
    private $tenantAddressBefore;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     */
    private $tenantAddressAfter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\OneToOne(targetEntity=Contract::class, inversedBy="guarantor", cascade={"persist", "remove"})
     */
    private $guarantorContract;

    /**
     * @ORM\OneToMany(targetEntity=Housing::class, mappedBy="owner")
     */
    private $ownerHousings;

    private $fullname;

    /**
     * @ORM\ManyToOne(targetEntity=Contract::class, inversedBy="tenants")
     */
    private $tenantsContract;


    public function __construct()
    {
        $this->ownerHousings = new ArrayCollection();
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

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getTenantAddressBefore(): ?Address
    {
        return $this->tenantAddressBefore;
    }

    public function setTenantAddressBefore(?Address $tenantAddressBefore): self
    {
        $this->tenantAddressBefore = $tenantAddressBefore;

        return $this;
    }

    public function getTenantAddressAfter(): ?Address
    {
        return $this->tenantAddressAfter;
    }

    public function setTenantAddressAfter(?Address $tenantAddressAfter): self
    {
        $this->tenantAddressAfter = $tenantAddressAfter;

        return $this;
    }


    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getGuarantorContract(): ?Contract
    {
        return $this->guarantorContract;
    }

    public function setGuarantorContract(?Contract $guarantorContract): self
    {
        $this->guarantorContract = $guarantorContract;

        return $this;
    }

    /**
     * @return Collection|Housing[]
     */
    public function getOwnerHousings(): Collection
    {
        return $this->ownerHousings;
    }

    public function addOwnerHousing(Housing $ownerHousing): self
    {
        if (!$this->ownerHousings->contains($ownerHousing)) {
            $this->ownerHousings[] = $ownerHousing;
            $ownerHousing->setOwner($this);
        }

        return $this;
    }

    public function removeOwnerHousing(Housing $ownerHousing): self
    {
        if ($this->ownerHousings->removeElement($ownerHousing)) {
            // set the owning side to null (unless already changed)
            if ($ownerHousing->getOwner() === $this) {
                $ownerHousing->setOwner(null);
            }
        }

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getTenantsContract(): ?Contract
    {
        return $this->tenantsContract;
    }

    public function setTenantsContract(?Contract $tenantsContract): self
    {
        $this->tenantsContract = $tenantsContract;

        return $this;
    }

}
