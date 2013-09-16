<?php

namespace EtoxMicrome\EntidadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enzima
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntidadBundle\Entity\EnzimaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Enzima
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
     * @ORM\OneToOne(targetEntity="EtoxMicrome\EvidenciaEntidadBundle\Entity\EvidenciaEntidad", cascade={"persist"})
     * @ORM\JoinColumn(name="evidenciaEntidad_id", referencedColumnName="id")
     */

    private $evidenciaEntidad;

    /**
     * @var string
     *
     * @ORM\Column(name="idUniprot", type="string", length=255, nullable=true)
     */

    private $idUniprot;

    /**
     * @ORM\OneToMany(targetEntity="EtoxMicrome\EntidadBundle\Entity\Proteina", mappedBy="enzima")
     **/

    private $proteina;

    /**
    * Constructor de la clase
    **/

    public function __construct() {
        $this->evidenciaEntidad = new \Doctrine\Common\Collections\ArrayCollection();
        $this->proteina = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set idUniprot
     *
     * @param string $idUniprot
     * @return Enzima
     */

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Compuesto
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
     * @return Compuesto
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
     * Set evidenciaEntidad
     *
     * @param string $evidenciaEntidad
     * @return Compuesto
     */
    public function setEvidenciaEntidad(\EtoxMicrome\EvidenciaEntidadBundle\Entity\EvidenciaEntidad $evidenciaEntidad)
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
     * Set proteina
     *
     * @param string $proteina
     * @return Compuesto
     */
    public function setProteina($proteina)
    {
        $this->proteina = $proteina;
    }

    /**
     * Get proteina
     *
     * @return string
     */
    public function getProteina()
    {
        return $this->proteina;
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

    public function __toString()
    {
        return (string)$this->getId();
    }
}
