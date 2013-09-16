<?php

namespace EtoxMicrome\RelacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Relacion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EtoxMicrome\RelacionBundle\Entity\RelacionRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Relacion
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
     *
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\EvidenciaEntidadBundle\Entity\EvidenciaEntidad")
     */

    private $evidenciaEntidadOrigen;

    /**
     *
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\EvidenciaEntidadBundle\Entity\EvidenciaEntidad")
     */

    private $evidenciaEntidadDestino;

    /**
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\RelacionBundle\Entity\TipoRelacion")
     **/
    private $tipoRelacion;

    /**
     * Get id
     *
     * @return integer
     */

     /**
     * @ORM\OneToMany(targetEntity="EtoxMicrome\RelacionUsuarioBundle\Entity\RelacionUsuario", mappedBy="relacion", cascade={"persist"})
     **/
    private $relacionUsuario;

    /**
    * Constructor de la clase
    **/
    public function __construct() {
        $this->relacionUsuario = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Relacion
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
     * @return Relacion
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
     * Set nombre
     *
     * @param string $nombre
     * @return Relacion
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Relacion
     */
    public function setTipoRelacion(\EtoxMicrome\RelacionBundle\Entity\TipoRelacion $tipoRelacion)
    {
        $this->tipoRelacion = $tipoRelacion;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipoRelacion()
    {
        return $this->tipoRelacion;
    }

    /**
     * Set entidadOrigen
     *
     */
    public function setEvidenciaEntidadOrigen(\EtoxMicrome\EvidenciaEntidadBundle\Entity\EvidenciaEntidad $evidenciaEntidadOrigen)
    {
        $this->evidenciaEntidadOrigen = $evidenciaEntidadOrigen;
        return $this;
    }

    /**
     * Get entidadOrigen
     */
    public function getEvidenciaEntidadOrigen()
    {
        return $this->evidenciaEntidadOrigen;
    }

    /**
     * Set entidadDestino
     *
     */
    public function setEvidenciaEntidadDestino(\EtoxMicrome\EvidenciaEntidadBundle\Entity\EvidenciaEntidad $evidenciaEntidadDestino)
    {
        $this->evidenciaEntidadDestino = $evidenciaEntidadDestino;
        return $this;
    }

    /**
     * Get entidadDestino
     */
    public function getEvidenciaEntidadDestino()
    {
        return $this->evidenciaEntidadDestino;
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
