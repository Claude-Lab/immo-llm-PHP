<?php
namespace App\Data;

use App\Entity\Address;
use App\Entity\Sort;
use App\Entity\Owner;


class SearchUsersData
{
    /**
     * @var string
     */
    public $fullname = '';

    
    /**
     * @var Tenant[]
     */
    public $tenants;

    /**
     * @var Owner[]
     */
    public $owners;

    /**
     * @var Guarantors[]
     */
    public $guarantors;

    /**
     * @var Managers[]
     */
    public $managers;
    
}