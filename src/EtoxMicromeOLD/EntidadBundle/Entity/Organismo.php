<?php

namespace EtoxMicrome\EntidadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Organismo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntidadBundle\Entity\OrganismoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Organismo
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
     * @var string
     *
     * @ORM\OneToOne(targetEntity="EtoxMicrome\EvidenciaEntidadBundle\Entity\EvidenciaEntidad")
     * @ORM\JoinColumn(name="evidenciaEntidad_id", referencedColumnName="id")
     */
    private $evidenciaEntidad;


    /**
     * @var string
     *
     * @ORM\Column(name="idNCBI", type="string", length=255, nullable=true)
     */
    private $idNCBI;


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
     * @return Organismo
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
     * @return Organismo
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
     * Set evidenciaEntidad
     *
     * @param string $entidad
     * @return Organismo
     */
    public function setEvidenciaEntidad(\EtoxMicrome\EntidadBundle\Entity\EvidenciaEntidad $evidenciaEntidad)
    {
        $this->evidenciaEntidad = $evidenciaEntidad;
    }

    /**
     * Get evidenciaEntidad
     *
     * @return string
     */
    public function getEvidenciaEntidad()
    {
        return $this->evidenciaEntidad;
    }

    /**
     * Set idNCBI
     *
     * @param string $idNCBI
     * @return Organismo
     */
    public function setIdNCBI($idNCBI)
    {
        $this->idNCBI = $idNCBI;

        return $this;
    }

    /**
     * Get idNCBI
     *
     * @return string
     */
    public function getIdNCBI()
    {
        return $this->idNCBI;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime('now');
        $this->updated = new \DateTime('now');
        $this->score = 1;
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
