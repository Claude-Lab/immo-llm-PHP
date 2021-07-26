<?php

namespace App\Entity;

use App\Repository\GuarantorRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GuarantorRepository::class)
 */
class Guarantor extends User
{

}
