<?php

namespace App\Entity;

use App\Repository\PropertyLoadRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=PropertyLoadRepository::class)
 * @ApiResource
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
     * @ORM\Column(type="integer")
     */
    private $quarter;

    /**
     * @ORM\Column(type="float")
     */
    private $rate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateLoad;

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

    public function setQuarter(int $quarter): self
    {
        $this->quarter = $quarter;

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getDateLoad(): ?\DateTimeInterface
    {
        return $this->dateLoad;
    }

    public function setDateLoad(\DateTimeInterface $dateLoad): self
    {
        $this->dateLoad = $dateLoad;

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
