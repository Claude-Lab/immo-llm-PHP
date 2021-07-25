<?php

namespace App\Entity;

use App\Repository\HousingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HousingRepository::class)
 */
class Housing
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
    private $nbRoom;

    /**
     * @ORM\Column(type="float")
     */
    private $surface;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rental;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $housingLoad;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $floor;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $attic;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $cellar;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $pool;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $box;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $landSurface;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbFloor;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $elevator;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbRoom(): ?int
    {
        return $this->nbRoom;
    }

    public function setNbRoom(int $nbRoom): self
    {
        $this->nbRoom = $nbRoom;

        return $this;
    }

    public function getSurface(): ?float
    {
        return $this->surface;
    }

    public function setSurface(float $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getRental(): ?float
    {
        return $this->rental;
    }

    public function setRental(?float $rental): self
    {
        $this->rental = $rental;

        return $this;
    }

    public function getHousingLoad(): ?float
    {
        return $this->housingLoad;
    }

    public function setHousingLoad(?float $housingLoad): self
    {
        $this->housingLoad = $housingLoad;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(?int $floor): self
    {
        $this->floor = $floor;

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

    public function getCellar(): ?bool
    {
        return $this->cellar;
    }

    public function setCellar(?bool $cellar): self
    {
        $this->cellar = $cellar;

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

    public function getLandSurface(): ?float
    {
        return $this->landSurface;
    }

    public function setLandSurface(?float $landSurface): self
    {
        $this->landSurface = $landSurface;

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

    public function getElevator(): ?bool
    {
        return $this->elevator;
    }

    public function setElevator(?bool $elevator): self
    {
        $this->elevator = $elevator;

        return $this;
    }
}
