<?php

namespace App\Entity;

use App\Repository\TenantRepository;
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
     */
    private $addressAfter;

    /**
     * @ORM\ManyToOne(targetEntity=Contract::class, inversedBy="tenant")
     */
    private $contract;

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

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(?Contract $contract): self
    {
        $this->contract = $contract;

        return $this;
    }
}
