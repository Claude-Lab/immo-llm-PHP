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
     * @ORM\ManyToOne(targetEntity=Contract::class, inversedBy="guarantor")
     */
    private $contract;

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
