<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TabTipoCaptura
 *
 * @ORM\Table(name="tab_tipo_captura")
 * @ORM\Entity
 */
class TabTipoCaptura
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_tipo_captura", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTipoCaptura;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_captura", type="string", length=50, nullable=true)
     */
    private $tipoCaptura;



    /**
     * Get idTipoCaptura
     *
     * @return string
     */
    public function getIdTipoCaptura()
    {
        return $this->idTipoCaptura;
    }

    /**
     * Set tipoCaptura
     *
     * @param string $tipoCaptura
     *
     * @return TabTipoCaptura
     */
    public function setTipoCaptura($tipoCaptura)
    {
        $this->tipoCaptura = $tipoCaptura;

        return $this;
    }

    /**
     * Get tipoCaptura
     *
     * @return string
     */
    public function getTipoCaptura()
    {
        return $this->tipoCaptura;
    }
}
