<?php

namespace App\Entity;

use App\Repository\HeatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HeatRepository::class)
 */
class Heat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $energy;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $setup;

    /**
     * @ORM\OneToMany(targetEntity=Housing::class, mappedBy="heat")
     */
    private $housings;

    public function __construct()
    {
        $this->housings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnergy(): ?string
    {
        return $this->energy;
    }

    public function setEnergy(string $energy): self
    {
        $this->energy = $energy;

        return $this;
    }

    public function getSetup(): ?string
    {
        return $this->setup;
    }

    public function setSetup(string $setup): self
    {
        $this->setup = $setup;

        return $this;
    }

    /**
     * @return Collection|Housing[]
     */
    public function getHousings(): Collection
    {
        return $this->housings;
    }

    public function addHousing(Housing $housing): self
    {
        if (!$this->housings->contains($housing)) {
            $this->housings[] = $housing;
            $housing->setHeat($this);
        }

        return $this;
    }

    public function removeHousing(Housing $housing): self
    {
        if ($this->housings->removeElement($housing)) {
            // set the owning side to null (unless already changed)
            if ($housing->getHeat() === $this) {
                $housing->setHeat(null);
            }
        }

        return $this;
    }
}
