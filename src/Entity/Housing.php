<?php

namespace App\Entity;

use App\Repository\HousingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=HousingRepository::class)
 * @ApiResource
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
    private $nbLevel;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $elevator;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity=Sort::class, inversedBy="housings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sort;

    /**
     * @ORM\ManyToOne(targetEntity=Heat::class, inversedBy="housings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $heat;

    /**
     * @ORM\OneToMany(targetEntity=Tax::class, mappedBy="housing")
     */
    private $taxes;

    /**
     * @ORM\OneToMany(targetEntity=PropertyLoad::class, mappedBy="housing")
     */
    private $propertyLoads;

    /**
     * @ORM\ManyToOne(targetEntity=Owner::class, inversedBy="housings")
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity=Contract::class, mappedBy="housing")
     */
    private $contracts;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
        $this->equipments = new ArrayCollection();
        $this->taxes = new ArrayCollection();
        $this->propertyLoads = new ArrayCollection();
    }

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

    public function getNbLevel(): ?int
    {
        return $this->nbLevel;
    }

    public function setNbLevel(?int $nbLevel): self
    {
        $this->nbLevel = $nbLevel;

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

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

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

    public function getHeat(): ?Heat
    {
        return $this->heat;
    }

    public function setHeat(?Heat $heat): self
    {
        $this->heat = $heat;

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

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(?Owner $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|Contract[]
     */
    public function getContracts(): Collection
    {
        return $this->contracts;
    }

    public function addContract(Contract $contract): self
    {
        if (!$this->contracts->contains($contract)) {
            $this->contracts[] = $contract;
            $contract->setHousing($this);
        }

        return $this;
    }

    public function removeContract(Contract $contract): self
    {
        if ($this->contracts->removeElement($contract)) {
            // set the owning side to null (unless already changed)
            if ($contract->getHousing() === $this) {
                $contract->setHousing(null);
            }
        }

        return $this;
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
}
