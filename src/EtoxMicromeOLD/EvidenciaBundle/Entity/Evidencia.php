<?php
namespace EtoxMicrome\EvidenciaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Evidencia
 *
 * @ORM\Table(options={"collate"="utf8_bin"},indexes={@ORM\Index(name="code_index", columns={"code"})})
 * @ORM\Entity(repositoryClass="EtoxMicrome\EvidenciaBundle\Entity\EvidenciaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Evidencia
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
     * @ORM\OneToOne(targetEntity="EtoxMicrome\OrigenBundle\Entity\Origen")
     * @ORM\JoinColumn(name="origen_id", referencedColumnName="id")
     * @Assert\Type(type="EtoxMicrome\OrigenBundle\Entity\Origen")
     **/
    protected $origen;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="texto", type="text")
     */
    private $texto;

    /**
     * @var integer
     *
     * @ORM\Column(name="curated", type="integer")
     */
    private $curated;

    /**
     * @var score
     *
     * @ORM\Column(name="score", type="integer")
     */
    private $score;


    /**
     * @ORM\OneToMany(targetEntity="EtoxMicrome\EvidenciaEntidadBundle\Entity\EvidenciaEntidad", mappedBy="evidencia", cascade={"persist"})
     **/
    private $evidenciaEntidad;

    /**
    * Constructor de la clase
    **/
    public function __construct() {
        $this->evidenciaEntidad = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set created
     *
     * @param \DateTime $created
     * @return Evidencia
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
     * @return Evidencia
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
     * Set origen
     */
    public function setOrigen(\EtoxMicrome\OrigenBundle\Entity\Origen $origen)
    {
        $this->origen = $origen;
        return $this;

    }

    /**
     * Get origen
     *
     */
    public function getOrigen()
    {
        return $this->origen;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Evidencia
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set texto
     *
     * @param string $texto
     * @return Evidencia
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * Get texto
     *
     * @return string
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set curated
     *
     * @param integer $curated
     * @return Evidencia
     */
    public function setCurated($curated)
    {
        $this->curated = $curated;

        return $this;
    }

    /**
     * Get curated
     *
     * @return integer
     */
    public function getCurated()
    {
        return $this->curated;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return integer
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set evidenciasEntidades
     *
     * @return integer
     */
    public function setEvidenciaEntidad($evidenciaEntidad)
    {
        $this->evidenciaEntidad =$evidenciaEntidad;
        return $this;
    }

    /**
     * Get evidenciasEntidades
     *
     * @return integer
     */
    public function getEvidenciaEntidad()
    {
        return $this->evidenciaEntidad;
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
