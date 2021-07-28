<?php

namespace App\Entity;

use App\Repository\HousingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HousingRepository::class)
 */
class Housing
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbRoom;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $surface;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rental;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rentalLoad;

    /**
     * @ORM\OneToOne(targetEntity=Contract::class, mappedBy="housing", cascade={"persist", "remove"})
     */
    private $contract;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=Equipment::class, mappedBy="housing")
     */
    private $equipments;

    /**
     * @ORM\OneToMany(targetEntity=Tax::class, mappedBy="housing")
     */
    private $taxes;

    /**
     * @ORM\OneToMany(targetEntity=PropertyLoad::class, mappedBy="housing")
     */
    private $propertyLoads;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="housing")
     */
    private $photos;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $floor;

    /**
     * @ORM\Column(type="boolean")
     */
    private $attic;

    /**
     * @ORM\Column(type="boolean")
     */
    private $cellar;

    /**
     * @ORM\Column(type="boolean")
     */
    private $pool;

    /**
     * @ORM\Column(type="boolean")
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
     * @ORM\Column(type="boolean")
     */
    private $elevator;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ownerHousings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity=Sort::class, inversedBy="housings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sort;


    public function __construct()
    {
        $this->equipments = new ArrayCollection();
        $this->options = new ArrayCollection();
        $this->taxes = new ArrayCollection();
        $this->propertyLoads = new ArrayCollection();
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbRoom(): ?int
    {
        return $this->nbRoom;
    }

    public function setNbRoom(?int $nbRoom): self
    {
        $this->nbRoom = $nbRoom;

        return $this;
    }

    public function getSurface(): ?float
    {
        return $this->surface;
    }

    public function setSurface(?float $surface): self
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

    public function getRentalLoad(): ?float
    {
        return $this->rentalLoad;
    }

    public function setRentalLoad(?float $rentalLoad): self
    {
        $this->rentalLoad = $rentalLoad;

        return $this;
    }

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(Contract $contract): self
    {
        // set the owning side of the relation if necessary
        if ($contract->getHousing() !== $this) {
            $contract->setHousing($this);
        }

        $this->contract = $contract;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|Equipment[]
     */
    public function getEquipments(): Collection
    {
        return $this->equipments;
    }

    public function addEquipment(Equipment $equipment): self
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments[] = $equipment;
            $equipment->setHousing($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->equipments->removeElement($equipment)) {
            // set the owning side to null (unless already changed)
            if ($equipment->getHousing() === $this) {
                $equipment->setHousing(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tax[]
     */
    public function getTaxes(): Collection
    {
        return $this->taxes;
    }

    public function addTax(Tax $tax): self
    {
        if (!$this->taxes->contains($tax)) {
            $this->taxes[] = $tax;
            $tax->setHousing($this);
        }

        return $this;
    }

    public function removeTax(Tax $tax): self
    {
        if ($this->taxes->removeElement($tax)) {
            // set the owning side to null (unless already changed)
            if ($tax->getHousing() === $this) {
                $tax->setHousing(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PropertyLoad[]
     */
    public function getPropertyLoads(): Collection
    {
        return $this->propertyLoads;
    }

    public function addPropertyLoad(PropertyLoad $propertyLoad): self
    {
        if (!$this->propertyLoads->contains($propertyLoad)) {
            $this->propertyLoads[] = $propertyLoad;
            $propertyLoad->setHousing($this);
        }

        return $this;
    }

    public function removePropertyLoad(PropertyLoad $propertyLoad): self
    {
        if ($this->propertyLoads->removeElement($propertyLoad)) {
            // set the owning side to null (unless already changed)
            if ($propertyLoad->getHousing() === $this) {
                $propertyLoad->setHousing(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Document $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setHousing($this);
        }

        return $this;
    }

    public function removePhoto(Document $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getHousing() === $this) {
                $photo->setHousing(null);
            }
        }
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

    public function setAttic(bool $attic): self
    {
        $this->attic = $attic;

        return $this;
    }

    public function getCellar(): ?bool
    {
        return $this->cellar;
    }

    public function setCellar(bool $cellar): self
    {
        $this->cellar = $cellar;

        return $this;
    }

    public function getPool(): ?bool
    {
        return $this->pool;
    }

    public function setPool(bool $pool): self
    {
        $this->pool = $pool;

        return $this;
    }

    public function getBox(): ?bool
    {
        return $this->box;
    }

    public function setBox(bool $box): self
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

    public function setElevator(bool $elevator): self
    {
        $this->elevator = $elevator;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getSort(): ?Sort
    {
        return $this->sort;
    }

    public function setSort(?Sort $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

}
