<?php

namespace App\Entity;

use App\Repository\ReceiptRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=ReceiptRepository::class)
 * @ApiResource
 */
class Receipt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="float")
     */
    private $rental;

    /**
     * @ORM\Column(type="float")
     */
    private $rentalLoad;

    /**
     * @ORM\ManyToOne(targetEntity=Contract::class, inversedBy="receipts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contract;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getRental(): ?float
    {
        return $this->rental;
    }

    public function setRental(float $rental): self
    {
        $this->rental = $rental;

        return $this;
    }

    public function getRentalLoad(): ?float
    {
        return $this->rentalLoad;
    }

    public function setRentalLoad(float $rentalLoad): self
    {
        $this->rentalLoad = $rentalLoad;

        return $this;
    }

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
