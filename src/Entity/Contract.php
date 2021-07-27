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
     * @ORM\ManyToOne(targetEntity=Housing::class, inversedBy="contracts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $housing;

    /**
     * @ORM\OneToMany(targetEntity=Receipt::class, mappedBy="contract")
     */
    private $receipts;

    /**
     * @ORM\OneToMany(targetEntity=Tenant::class, mappedBy="contract")
     */
    private $tenant;

    /**
     * @ORM\OneToMany(targetEntity=Guarantor::class, mappedBy="contract")
     */
    private $guarantor;

    public function __construct()
    {
        $this->receipts = new ArrayCollection();
        $this->guarantorUser = new ArrayCollection();
        $this->tenant = new ArrayCollection();
        $this->guarantor = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
    public function getTenant(): Collection
    {
        return $this->tenant;
    }

    public function addTenant(Tenant $tenant): self
    {
        if (!$this->tenant->contains($tenant)) {
            $this->tenant[] = $tenant;
            $tenant->setContract($this);
        }

        return $this;
    }

    public function removeTenant(Tenant $tenant): self
    {
        if ($this->tenant->removeElement($tenant)) {
            // set the owning side to null (unless already changed)
            if ($tenant->getContract() === $this) {
                $tenant->setContract(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Guarantor[]
     */
    public function getGuarantor(): Collection
    {
        return $this->guarantor;
    }

    public function addGuarantor(Guarantor $guarantor): self
    {
        if (!$this->guarantor->contains($guarantor)) {
            $this->guarantor[] = $guarantor;
            $guarantor->setContract($this);
        }

        return $this;
    }

    public function removeGuarantor(Guarantor $guarantor): self
    {
        if ($this->guarantor->removeElement($guarantor)) {
            // set the owning side to null (unless already changed)
            if ($guarantor->getContract() === $this) {
                $guarantor->setContract(null);
            }
        }

        return $this;
    }

}
