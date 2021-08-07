<?php

namespace App\Entity;

use App\Repository\GuarantorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GuarantorRepository::class)
 */
class Guarantor extends User
{

    /**
     * @ORM\OneToOne(targetEntity=Tenant::class, inversedBy="guarantor", cascade={"persist", "remove"})
     */
    private $tenant;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    /**
     * @ORM\ManyToMany(targetEntity=Tenant::class, mappedBy="guarantors")
     */
    private $tenants;

    public function __construct()
    {
        $this->tenants = new ArrayCollection();
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
            $tenant->addGuarantor($this);
        }

        return $this;
    }

    public function removeTenant(Tenant $tenant): self
    {
        if ($this->tenants->removeElement($tenant)) {
            $tenant->removeGuarantor($this);
        }

        return $this;
    }
}
