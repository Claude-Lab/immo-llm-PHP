<?php

namespace App\Entity;

use App\Repository\TenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TenantRepository::class)
 */
class Tenant extends User
{

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     */
    private $addressBefore;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $addressAfter;

    /**
     * @ORM\ManyToMany(targetEntity=Contract::class, mappedBy="tenants")
     */
    private $contracts;

    /**
     * @ORM\ManyToMany(targetEntity=Guarantor::class, inversedBy="tenants")
     */
    private $guarantors;

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
        $this->guarantors = new ArrayCollection();
    }

    public function getAddressBefore(): ?Address
    {
        return $this->addressBefore;
    }

    public function setAddressBefore(?Address $addressBefore): self
    {
        $this->addressBefore = $addressBefore;

        return $this;
    }

    public function getAddressAfter(): ?Address
    {
        return $this->addressAfter;
    }

    public function setAddressAfter(?Address $addressAfter): self
    {
        $this->addressAfter = $addressAfter;

        return $this;
    }

    /**
     * @return Collection|Contract[]
     */
    public function getContracts(): Collection
    {
        return $this->contracts;
    }

    public function addContract(Contract $contract): self
    {
        if (!$this->contracts->contains($contract)) {
            $this->contracts[] = $contract;
            $contract->addTenant($this);
        }

        return $this;
    }

    public function removeContract(Contract $contract): self
    {
        if ($this->contracts->removeElement($contract)) {
            $contract->removeTenant($this);
        }

        return $this;
    }

    /**
     * @return Collection|Guarantor[]
     */
    public function getGuarantors(): Collection
    {
        return $this->guarantors;
    }

    public function addGuarantor(Guarantor $guarantor): self
    {
        if (!$this->guarantors->contains($guarantor)) {
            $this->guarantors[] = $guarantor;
        }

        return $this;
    }

    public function removeGuarantor(Guarantor $guarantor): self
    {
        $this->guarantors->removeElement($guarantor);

        return $this;
    }

}
