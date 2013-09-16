<?php

namespace EtoxMicrome\RelacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\OneToOne(targetEntity="EtoxMicrome\EvidenciaEntidadBundle\Entity\EvidenciaEntidad")
     * @ORM\JoinColumn(name="entidad_id", referencedColumnName="id")
     */

    private $entidadOrigen;

    /**
     *
     * @ORM\OneToOne(targetEntity="EtoxMicrome\EvidenciaEntidadBundle\Entity\EvidenciaEntidad")
     * @ORM\JoinColumn(name="entidad_id", referencedColumnName="id")
     */

    private $entidadDestino;

    /**
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\RelacionBundle\Entity\TipoRelacion", inversedBy="relaciones")
     * @ORM\JoinColumn(name="tipoRelacion_id", referencedColumnName="id")
     **/
    private $tipoRelacion;

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
    public function setEntidadOrigen(\EtoxMicrome\EvidenciaEntidadBundle\Entity\EvidenciaEntidad $entidadOrigen)
    {
        $this->entidadOrigen = $entidadOrigen;
        return $this;
    }

    /**
     * Get entidadOrigen
     */
    public function getEntidadOrigen()
    {
        return $this->entidadOrigen;
    }

    /**
     * Set entidadDestino
     *
     */
    public function setEntidadDestino(\EtoxMicrome\EvidenciaEntidadBundle\Entity\EvidenciaEntidad $entidadDestino)
    {
        $this->entidadDestino = $entidadDestino;
        return $this;
    }

    /**
     * Get entidadDestino
     */
    public function getEntidadDestino()
    {
        return $this->entidadDestino;
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
