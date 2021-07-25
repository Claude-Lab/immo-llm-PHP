<?php

namespace App\Entity;

use App\Repository\HeatRepository;
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
}
