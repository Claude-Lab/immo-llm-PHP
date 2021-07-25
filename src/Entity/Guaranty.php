<?php

namespace App\Entity;

use App\Repository\GuarantyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GuarantyRepository::class)
 */
class Guaranty extends User
{

}
