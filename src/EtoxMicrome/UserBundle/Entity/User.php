<?php

namespace EtoxMicrome\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="EtoxMicrome\RelacionUsuarioBundle\Entity\RelacionUsuario", mappedBy="user")
     **/
    private $relacionUsuario;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->relacionUsuario = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set relacionUsuarios
     *
     * @return integer
     */
    public function setRelacionUsuario($relacionUsuario)
    {
        $this->relacionUsuario =$relacionUsuario;
        return $this;
    }

    /**
     * Get relacionUsuarios
     *
     * @return integer
     */
    public function getRelacionUsuario()
    {
        return $this->relacionUsuario;
    }
}