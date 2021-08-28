<?php

namespace App\Entity;

use App\Repository\TenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TenantRepository::class)
 * @ApiResource
 */
class Tenant extends User
{

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     * @Groups("user:read")
     */
    private $addressBefore;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     * @Groups("user:read")
     */
    private $addressAfter;

    /**
     * @ORM\ManyToMany(targetEntity=Contract::class, mappedBy="tenants")
     * @Groups("user:read")
     */
    private $contracts;

    /**
     * @ORM\ManyToOne(targetEntity=Guarantor::class, inversedBy="tenants")
     * @Groups("user:read")
     */
    private $guarantor;

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
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

    public function getGuarantor(): ?Guarantor
    {
        return $this->guarantor;
    }

    public function setGuarantor(?Guarantor $guarantor): self
    {
        $this->guarantor = $guarantor;

        return $this;
    }

    

}
