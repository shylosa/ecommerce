<?php
/**
 * Created by PhpStorm.
 * User: skillup_student
 * Date: 30.04.19
 * Time: 19:27
 */

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping  as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "site_user")
 */
class User extends BaseUser
{
/**
 * @ORM\Id
 * @ORM\Column(type = "integer")
 * @ORM\GeneratedValue(strategy = "AUTO")
 */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }
}