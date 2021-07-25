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
}
