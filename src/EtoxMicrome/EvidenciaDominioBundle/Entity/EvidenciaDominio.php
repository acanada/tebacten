<?php

namespace EtoxMicrome\EvidenciaDominioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvidenciaDominio
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EtoxMicrome\EvidenciaDominioBundle\Entity\EvidenciaDominioRepository")
 */
class EvidenciaDominio
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
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\DominioBundle\Entity\Dominio", inversedBy="evidenciasDominios")
     * @ORM\JoinColumn(name="dominio_id", referencedColumnName="id")
     **/
    private $dominio;

    /**
     *
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\EvidenciaBundle\Entity\Evidencia")
     */
    private $evidencia;

    /**
     * @var float
     *
     * @ORM\Column(name="score", type="float", nullable=true)
     */
    private $score;


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
     * @return EvidenciaDominio
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
     * @return EvidenciaDominio
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
     * Set dominio
     */
    public function setDominio(\EtoxMicrome\DominioBundle\Entity\Dominio  $dominio)
    {
        $this->dominio = $dominio;
        return $this;
    }

    /**
     * Get dominio
     */
    public function getDominio()
    {
        return $this->dominio;
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
     * @return EvidenciaDominio
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
     * Metodo toString
     */
    public function __toString()
    {
        return (string) $this->getId();
    }
}
