<?php

namespace App\Entity;

use App\Repository\PropertyLoadRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PropertyLoadRepository::class)
 */
class PropertyLoad
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quarter;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateTax;

    /**
     * @ORM\ManyToOne(targetEntity=Housing::class, inversedBy="propertyLoads")
     */
    private $housing;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuarter(): ?int
    {
        return $this->quarter;
    }

    public function setQuarter(?int $quarter): self
    {
        $this->quarter = $quarter;

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(?float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getDateTax(): ?\DateTimeInterface
    {
        return $this->dateTax;
    }

    public function setDateTax(?\DateTimeInterface $dateTax): self
    {
        $this->dateTax = $dateTax;

        return $this;
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
}
