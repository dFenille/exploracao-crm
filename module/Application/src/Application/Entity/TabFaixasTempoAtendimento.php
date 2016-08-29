<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TabFaixasTempoAtendimento
 *
 * @ORM\Table(name="tab_faixas_tempo_atendimento")
 * @ORM\Entity
 */
class TabFaixasTempoAtendimento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_faixa", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFaixa;

    /**
     * @var string
     *
     * @ORM\Column(name="lim_inf_hh", type="decimal", precision=8, scale=2, nullable=false)
     */
    private $limInfHh;

    /**
     * @var string
     *
     * @ORM\Column(name="lim_sup_hh", type="decimal", precision=8, scale=2, nullable=false)
     */
    private $limSupHh;



    /**
     * Get idFaixa
     *
     * @return integer
     */
    public function getIdFaixa()
    {
        return $this->idFaixa;
    }

    /**
     * Set limInfHh
     *
     * @param string $limInfHh
     *
     * @return TabFaixasTempoAtendimento
     */
    public function setLimInfHh($limInfHh)
    {
        $this->limInfHh = $limInfHh;

        return $this;
    }

    /**
     * Get limInfHh
     *
     * @return string
     */
    public function getLimInfHh()
    {
        return $this->limInfHh;
    }

    /**
     * Set limSupHh
     *
     * @param string $limSupHh
     *
     * @return TabFaixasTempoAtendimento
     */
    public function setLimSupHh($limSupHh)
    {
        $this->limSupHh = $limSupHh;

        return $this;
    }

    /**
     * Get limSupHh
     *
     * @return string
     */
    public function getLimSupHh()
    {
        return $this->limSupHh;
    }
}
