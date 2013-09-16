<?php

namespace EtoxMicrome\EvidenciaEntidadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvidenciaEntidad
 *
 * @ORM\Table(options={"collate"="utf8_bin"},indexes={@ORM\Index(name="textminingName", columns={"textminingName"})})
 * @ORM\Entity(repositoryClass="EtoxMicrome\EvidenciaEntidadBundle\Entity\EvidenciaEntidadRepository")
 * @ORM\HasLifecycleCallbacks
 */
class EvidenciaEntidad
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
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\EvidenciaBundle\Entity\Evidencia", inversedBy="evidenciaEntidad")
     * @ORM\JoinColumn(name="evidencia_id", referencedColumnName="id")
     **/
    private $evidencia;


    /**
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\EntidadBundle\Entity\Entidad", inversedBy="evidenciaEntidad")
     * @ORM\JoinColumn(name="entidad_id", referencedColumnName="id")
     **/
    private $entidad;

    /**
     * @var float
     *
     * @ORM\Column(name="score", type="float")
     */
    private $score;

    /**
     * @var string
     *
     * @ORM\Column(name="textminingName", type="string")
     */
    private $textminingName;

    /**
     * @ORM\OneToOne(targetEntity="EtoxMicrome\EntidadBundle\Entity\Compuesto", mappedBy="evidenciaEntidad", cascade={"persist","remove"})
     **/
    private $compuesto;

     /**
     * @ORM\OneToOne(targetEntity="EtoxMicrome\EntidadBundle\Entity\Organismo", mappedBy="evidenciaEntidad", cascade={"persist","remove"})
     **/
    private $organismo;

     /**
     * @ORM\OneToOne(targetEntity="EtoxMicrome\EntidadBundle\Entity\Enzima", mappedBy="evidenciaEntidad", cascade={"persist","remove"})
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
     * @return EvidenciaEntidad
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
     * @return EvidenciaEntidad
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
     * Set entidad
     */
    public function setEntidad(\EtoxMicrome\EntidadBundle\Entity\Entidad $entidad)
    {
        $this->entidad = $entidad;
        return $this;
    }

    /**
     * Get entidad
     */
    public function getEntidad()
    {
        return $this->entidad;
    }

    /**
     * Set evidencia
     */
    public function setEvidencia(\EtoxMicrome\EvidenciaBundle\Entity\Evidencia $evidencia)
    {
        $this->evidencia = $evidencia;
        return $this;
    }

    /**
     * Get evidencia
     */
    public function getEvidencia()
    {
        return $this->evidencia;
    }

    /**
     * Set score
     *
     * @param float $score
     * @return EvidenciaEntidad
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set textminingName
     *
     * @return string
     */
    public function setTextminingName($textminingName)
    {
        $this->textminingName =$textminingName;
        return $this;
    }

    /**
     * Get textminingName
     *
     * @return string
     */
    public function getTextminingName()
    {
        return $this->textminingName;
    }

    /**
     * Set compuesto
     *
     * @return integer
     */
    public function setCompuesto(\EtoxMicrome\EntidadBundle\Entity\Compuesto $compuesto)
    {
        $this->compuesto =$compuesto;
        return $this;
    }

    /**
     * Get compuesto
     *
     * @return integer
     */
    public function getCompuesto()
    {
        return $this->compuesto;
    }

    /**
     * Set organismo
     *
     * @return integer
     */
    public function setOrganismo(\EtoxMicrome\EntidadBundle\Entity\Organismo $organismo)
    {
        $this->organismo =$organismo;
        return $this;
    }

    /**
     * Get organismo
     *
     * @return integer
     */
    public function getOrganismo()
    {
        return $this->organismo;
    }

    /**
     * Set organismo
     *
     * @return integer
     */
    public function setEnzima(\EtoxMicrome\EntidadBundle\Entity\Enzima $enzima)
    {
        $this->enzima =$enzima;
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
