<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=ContractRepository::class)
 * @ApiResource
 */
class Contract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\OneToMany(targetEntity=Receipt::class, mappedBy="contract")
     */
    private $receipts;

    /**
     * @ORM\ManyToMany(targetEntity=Tenant::class, inversedBy="contracts")
     */
    private $tenants;

    /**
     * @ORM\ManyToOne(targetEntity=Housing::class, inversedBy="contracts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $housing;

    /**
     * @ORM\Column(type="float")
     */
    private $rent;

    /**
     * @ORM\Column(type="float")
     */
    private $rentLoad;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * @ORM\Column(type="float")
     */
    private $securityDeposit;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Equipment::class, inversedBy="contracts")
     */
    private $equipments;

   

    public function __construct()
    {
        $this->receipts = new ArrayCollection();
        $this->guarantorUser = new ArrayCollection();
        $this->tenants = new ArrayCollection();
        $this->equipments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

  
    /**
     * @return Collection|Receipt[]
     */
    public function getReceipts(): Collection
    {
        return $this->receipts;
    }

    public function addReceipt(Receipt $receipt): self
    {
        if (!$this->receipts->contains($receipt)) {
            $this->receipts[] = $receipt;
            $receipt->setContract($this);
        }

        return $this;
    }

    public function removeReceipt(Receipt $receipt): self
    {
        if ($this->receipts->removeElement($receipt)) {
            // set the owning side to null (unless already changed)
            if ($receipt->getContract() === $this) {
                $receipt->setContract(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tenant[]
     */
    public function getTenants(): Collection
    {
        return $this->tenants;
    }

    public function addTenant(Tenant $tenant): self
    {
        if (!$this->tenants->contains($tenant)) {
            $this->tenants[] = $tenant;
        }

        return $this;
    }

    public function removeTenant(Tenant $tenant): self
    {
        $this->tenants->removeElement($tenant);

        return $this;
    }

    public function getHousing(): ?Housing
    {
        return $this->housing;
    }

    public function setHousing(?Housing $housing): self
    {
        $this->housing = $housing;

        return $this;
    }

    public function getRent(): ?float
    {
        return $this->rent;
    }

    public function setRent(float $rent): self
    {
        $this->rent = $rent;

        return $this;
    }

    public function getRentLoad(): ?float
    {
        return $this->rentLoad;
    }

    public function setRentLoad(float $rentLoad): self
    {
        $this->rentLoad = $rentLoad;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    

    public function getSecurityDeposit(): ?float
    {
        return $this->securityDeposit;
    }

    public function setSecurityDeposit(float $securityDeposit): self
    {
        $this->securityDeposit = $securityDeposit;

        return $this;
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
     * @return Collection|Equipment[]
     */
    public function getEquipments(): Collection
    {
        return $this->equipments;
    }

    public function addEquipment(Equipment $equipment): self
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments[] = $equipment;
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        $this->equipments->removeElement($equipment);

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }


}
