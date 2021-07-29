<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContractRepository::class)
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
     * @ORM\Column(type="float")
     */
    private $rentWithLoad;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\OneToOne(targetEntity=Housing::class, inversedBy="contract", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $housing;

    /**
     * @ORM\OneToMany(targetEntity=Receipt::class, mappedBy="contract")
     */
    private $receipts;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="contract")
     */
    private $documents;

    /**
     * @ORM\Column(type="float")
     */
    private $securityDeposit;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="guarantorContract", cascade={"persist", "remove"})
     */
    private $guarantor;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="tenantsContract")
     */
    private $tenants;

    /**
     * @ORM\ManyToMany(targetEntity=Equipment::class, inversedBy="contracts")
     */
    private $equipments;

    public function __construct()
    {
        $this->receipts = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->tenants = new ArrayCollection();
        $this->equipments = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRentWithLoad(): ?float
    {
        return $this->rentWithLoad;
    }

    public function setRentWithLoad(float $rentWithLoad): self
    {
        $this->rentWithLoad = $rentWithLoad;

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

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }


    public function getHousing(): ?Housing
    {
        return $this->housing;
    }

    public function setHousing(Housing $housing): self
    {
        $this->housing = $housing;

        return $this;
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
     * @return Collection|Document[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setContract($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getContract() === $this) {
                $document->setContract(null);
            }
        }

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

    public function getGuarantor(): ?User
    {
        return $this->guarantor;
    }

    public function setGuarantor(?User $guarantor): self
    {
        // unset the owning side of the relation if necessary
        if ($guarantor === null && $this->guarantor !== null) {
            $this->guarantor->setGuarantorContract(null);
        }

        // set the owning side of the relation if necessary
        if ($guarantor !== null && $guarantor->getGuarantorContract() !== $this) {
            $guarantor->setGuarantorContract($this);
        }

        $this->guarantor = $guarantor;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getTenants(): Collection
    {
        return $this->tenants;
    }

    public function addTenant(User $tenant): self
    {
        if (!$this->tenants->contains($tenant)) {
            $this->tenants[] = $tenant;
            $tenant->setTenantsContract($this);
        }

        return $this;
    }

    public function removeTenant(User $tenant): self
    {
        if ($this->tenants->removeElement($tenant)) {
            // set the owning side to null (unless already changed)
            if ($tenant->getTenantsContract() === $this) {
                $tenant->setTenantsContract(null);
            }
        }

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
}
