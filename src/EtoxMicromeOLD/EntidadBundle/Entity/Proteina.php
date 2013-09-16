<?php

namespace EtoxMicrome\EntidadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proteina
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntidadBundle\Entity\ProteinaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Proteina
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
     * @ORM\Column(name="idUniprot", type="string", length=255)
     */
    private $idUniprot;

    /**
     * @var string
     *
     * @ORM\Column(name="idOrganismNCBI", type="string", length=255)
     */
    private $idOrganismNCBI;



    /**
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\EntidadBundle\Entity\Enzima", inversedBy="proteina")
     * @ORM\JoinColumn(name="enzima_id", referencedColumnName="id")
     **/
    private $enzima;

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
     * @return Proteina
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
     * @return Proteina
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
     * Set idUniprot
     *
     * @param string $idUniprot
     * @return Proteina
     */
    public function setIdUniprot($idUniprot)
    {
        $this->idUniprot = $idUniprot;

        return $this;
    }

    /**
     * Get idUniprot
     *
     * @return string
     */
    public function getIdUniprot()
    {
        return $this->idUniprot;
    }

    /**
     * Set idOrganismNCBI
     *
     * @param string $idOrganismNCBI
     * @return Proteina
     */
    public function setIdOrganismNCBI($idOrganismNCBI)
    {
        $this->idOrganismNCBI = $idOrganismNCBI;

        return $this;
    }

    /**
     * Get idOrganismNCBI
     *
     * @return string
     */
    public function getIdOrganismNCBI()
    {
        return $this->idOrganismNCBI;
    }

    /**
     * Set enzima
     *
     * @param integer $enzima
     * @return Proteina
     */
    public function setEnzima(\EtoxMicrome\EntidadBundle\Entity\Enzima $enzima)
    {
        $this->enzima = $enzima;

        return $this;
    }

    /**
     * Get enzima
     *
     * @return integer
     */
    public function getEnzima()
    {
        return $this->enzima;
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
