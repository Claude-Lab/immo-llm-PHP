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
     * @ORM\ManyToMany(targetEntity=Tenant::class, inversedBy="contracts")
     */
    private $tenants;

    public function __construct()
    {
        $this->receipts = new ArrayCollection();
        $this->guarantorUser = new ArrayCollection();
        $this->tenants = new ArrayCollection();
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


}
