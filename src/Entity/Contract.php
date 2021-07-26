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
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="contracts")
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="tenantContract", cascade={"persist", "remove"})
     */
    private $tenantUser;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ownerContract")
     */
    private $ownerUser;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="guarantorContract")
     */
    private $guarantorUser;

    public function __construct()
    {
        $this->receipts = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->guarantorUser = new ArrayCollection();
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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

    public function getTenantUser(): ?User
    {
        return $this->tenantUser;
    }

    public function setTenantUser(?User $tenantUser): self
    {
        // unset the owning side of the relation if necessary
        if ($tenantUser === null && $this->tenantUser !== null) {
            $this->tenantUser->setTenantContract(null);
        }

        // set the owning side of the relation if necessary
        if ($tenantUser !== null && $tenantUser->getTenantContract() !== $this) {
            $tenantUser->setTenantContract($this);
        }

        $this->tenantUser = $tenantUser;

        return $this;
    }

    public function getOwnerUser(): ?User
    {
        return $this->ownerUser;
    }

    public function setOwnerUser(?User $ownerUser): self
    {
        $this->ownerUser = $ownerUser;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getGuarantorUser(): Collection
    {
        return $this->guarantorUser;
    }

    public function addGuarantorUser(User $guarantorUser): self
    {
        if (!$this->guarantorUser->contains($guarantorUser)) {
            $this->guarantorUser[] = $guarantorUser;
            $guarantorUser->setGuarantorContract($this);
        }

        return $this;
    }

    public function removeGuarantorUser(User $guarantorUser): self
    {
        if ($this->guarantorUser->removeElement($guarantorUser)) {
            // set the owning side to null (unless already changed)
            if ($guarantorUser->getGuarantorContract() === $this) {
                $guarantorUser->setGuarantorContract(null);
            }
        }

        return $this;
    }

}
