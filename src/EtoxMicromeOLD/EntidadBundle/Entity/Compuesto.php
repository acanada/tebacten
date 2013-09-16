<?php

namespace EtoxMicrome\EntidadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Compuesto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntidadBundle\Entity\CompuestoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Compuesto
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
     * @var float
     *
     * @ORM\Column(name="substrateScore", type="float", nullable=true)
     */
    private $substrateScore;

    /**
     * @var float
     *
     * @ORM\Column(name="productScore", type="float", nullable=true)
     */
    private $productScore;

    /**
     * @var float
     *
     * @ORM\Column(name="reactionScore", type="float", nullable=true)
     */
    private $reactionScore;

    /**
     * @var float
     *
     * @ORM\Column(name="emptyScore", type="float", nullable=true)
     */
    private $emptyScore;

    /**
     * @var string
     *
     * @ORM\Column(name="inputOutput", type="string")
     */
    private $inputOutput="";

     /**
     * @var string
     *
     * @ORM\Column(name="chebiId", type="string", length=255, nullable=true)
     */
    protected $chebiId;


    public function getId()
    {
        return $this->id;
    }

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


    public function setSubstrateScore($substrateScore)
    {
        $this->substrateScore = $substrateScore;

        return $this;
    }
    /**
     * Get substrateScore
     *
     * @return float
     */
    public function getSubstrateScore()
    {
        return $this->substrateScore;
    }



    public function setProductScore($productScore)
    {
        $this->productScore = $productScore;

        return $this;
    }
    /**
     * Get productScore
     *
     * @return float
     */
    public function getProductScore()
    {
        return $this->productScore;
    }


    public function setReactionScore($reactionScore)
    {
        $this->reactionScore = $reactionScore;

        return $this;
    }
    /**
     * Get reactionScore
     *
     * @return float
     */
    public function getReactionScore()
    {
        return $this->reactionScore;
    }


    public function setEmptyScore($emptyScore)
    {
        $this->emptyScore = $emptyScore;

        return $this;
    }
    /**
     * Get emptyScore
     *
     * @return float
     */
    public function getEmptyScore()
    {
        return $this->emptyScore;
    }


    public function setChebiId($chebiId)
    {
        $this->chebiId = $chebiId;

        return $this;
    }

    /**
     * Get chebiId
     *
     * @return string
     */
    public function getChebiId()
    {
        return $this->chebiId;
    }

    /**
     * Set inputOutput
     *
     * @return string
     */
    public function setInputOutput($inputOutput)
    {
        $this->inputOutput =$inputOutput;
        return $this;
    }

    /**
     * Get inputOutput
     *
     * @return string
     */
    public function getInputOutput()
    {
        return $this->inputOutput;
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
