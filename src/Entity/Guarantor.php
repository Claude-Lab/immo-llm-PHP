<?php

namespace App\Entity;

use App\Repository\GuarantorRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GuarantorRepository::class)
 */
class Guarantor extends User
{

    /**
     * @ORM\OneToOne(targetEntity=Tenant::class, mappedBy="guarantor", cascade={"persist", "remove"})
     */
    private $tenant;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    public function getTenant(): ?Tenant
    {
        return $this->tenant;
    }

    public function setTenant(Tenant $tenant): self
    {
        // set the owning side of the relation if necessary
        if ($tenant->getGuarantor() !== $this) {
            $tenant->setGuarantor($this);
        }

        $this->tenant = $tenant;

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
}
