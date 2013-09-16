<?php

namespace EtoxMicrome\RelacionUsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RelacionUsuario
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EtoxMicrome\RelacionUsuarioBundle\Entity\RelacionUsuarioRepository")
 * @ORM\HasLifecycleCallbacks
 */
class RelacionUsuario
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\RelacionBundle\Entity\Relacion", inversedBy="relacionUsuario")
     * @ORM\JoinColumn(name="relacion_id", referencedColumnName="id")
     **/
    private $relacion;

    /**
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\UserBundle\Entity\User", inversedBy="relacionUsuario")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $user;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return RelacionUsuario
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return RelacionUsuario
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set relacion
     */
    public function setRelacion(\EtoxMicrome\RelacionBundle\Entity\Relacion $relacion)
    {
        $this->relacion = $relacion;
        return $this;
    }

    /**
     * Get relacion
     */
    public function getRelacion()
    {
        return $this->relacion;
    }

    /**
     * Set user
     */
    public function setUser(\EtoxMicrome\UserBundle\Entity\User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime('now');
        $this->updated = new \DateTime('now');
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated = new \DateTime('now');
    }

    /**
     * Metodo toString
     */
    public function __toString()
    {
        return (string)$this->getId();
    }
}
