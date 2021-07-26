<?php
namespace App\Data;

use App\Entity\Address;
use App\Entity\Sort;
use App\Entity\Owner;


class CreateHousingData {

    /*
    * @Assert\NotNull(message="La valeur ne peut-être nulle")
    * @var IntegerType
    */
    public $nbRoom;

    /*
    * @Assert\NotNull(message="La valeur ne peut-être nulle")
    * @var float
    */
    public $surface;

    /*
    * @Assert\NotNull(message="La valeur ne peut-être nulle")
    * @var float
    */
    public $rental;

    /*
    * @Assert\NotNull(message="La valeur ne peut-être nulle")
    * @var float
    */
    public $housingLoad;

    /*
    * @Assert\NotNull(message="La valeur ne peut-être nulle")
    * @var IntegerType
    */
    public $floor;

    /**
     * @var boolean
     */
    public $attic = false;

    /**
     * @var boolean
     */
    public $cellar = false;

    /**
     * @var boolean
     */
    public $pool = false;

    /**
     * @var boolean
     */
    public $box = false;

    /**
     * @Assert\NotNull(message="La valeur ne peut-être nulle")
     * @var float
     */
    public $landSurface;

    /*
    * @Assert\NotNull(message="La valeur ne peut-être nulle")
    * @var IntegerType
    */
    public $nbFloor;

    /**
     * @var boolean
     */
    public $elevator;

    /**
     * @Assert\NotNull(message="La valeur ne peut-être nulle")
     * @var Owner
     */
    public $owner;

    /**
     * @Assert\NotNull(message="La valeur ne peut-être nulle")
     * @var Address
     */
    public $address;

    /**
     * @Assert\NotNull(message="La valeur ne peut-être nulle")
     * @var Sort
     */
    public $sort;
}