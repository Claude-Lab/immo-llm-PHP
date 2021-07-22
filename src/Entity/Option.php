<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OptionRepository::class)
 * @ORM\Table(name="`option`")
 */
class Option
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $elevator;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbFloor;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $landSurface;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $pool;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $box;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $cellar;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $attic;

    /**
     * @ORM\ManyToOne(targetEntity=Housing::class, inversedBy="options")
     */
    private $housing;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getElevator(): ?bool
    {
        return $this->elevator;
    }

    public function setElevator(?bool $elevator): self
    {
        $this->elevator = $elevator;

        return $this;
    }

    public function getNbFloor(): ?int
    {
        return $this->nbFloor;
    }

    public function setNbFloor(?int $nbFloor): self
    {
        $this->nbFloor = $nbFloor;

        return $this;
    }

    public function getLandSurface(): ?float
    {
        return $this->landSurface;
    }

    public function setLandSurface(?float $landSurface): self
    {
        $this->landSurface = $landSurface;

        return $this;
    }

    public function getPool(): ?bool
    {
        return $this->pool;
    }

    public function setPool(?bool $pool): self
    {
        $this->pool = $pool;

        return $this;
    }

    public function getBox(): ?bool
    {
        return $this->box;
    }

    public function setBox(?bool $box): self
    {
        $this->box = $box;

        return $this;
    }

    public function getCellar(): ?bool
    {
        return $this->cellar;
    }

    public function setCellar(?bool $cellar): self
    {
        $this->cellar = $cellar;

        return $this;
    }

    public function getAttic(): ?bool
    {
        return $this->attic;
    }

    public function setAttic(?bool $attic): self
    {
        $this->attic = $attic;

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
