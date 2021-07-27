<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipmentRepository::class)
 */
class Equipment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $modality;

    /**
     * @ORM\Column(type="boolean")
     */
    private $inUse;

    /**
     * @ORM\ManyToOne(targetEntity=Housing::class, inversedBy="equipments")
     */
    private $housing;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $brandt;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $serialNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getModality(): ?string
    {
        return $this->modality;
    }

    public function setModality(?string $modality): self
    {
        $this->modality = $modality;

        return $this;
    }

    public function getInUse(): ?bool
    {
        return $this->inUse;
    }

    public function setInUse(bool $inUse): self
    {
        $this->inUse = $inUse;

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

    public function getBrandt(): ?string
    {
        return $this->brandt;
    }

    public function setBrandt(string $brandt): self
    {
        $this->brandt = $brandt;

        return $this;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    public function setSerialNumber(?string $serialNumber): self
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }
}
