<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Temporeacao
 *
 * @ORM\Table(name="TempoReacao", indexes={@ORM\Index(name="id_conversa", columns={"id_conversa"}), @ORM\Index(name="id_canal", columns={"id_Canal"})})
 * @ORM\Entity
 */
class Temporeacao
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_tempoReacao", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTemporeacao;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_Canal", type="integer", nullable=true)
     */
    private $idCanal;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_conversa", type="integer", nullable=true)
     */
    private $idConversa;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_post", type="bigint", nullable=true)
     */
    private $idPost;

    /**
     * @var integer
     *
     * @ORM\Column(name="tempo_minutos_brutos", type="bigint", nullable=true)
     */
    private $tempoMinutosBrutos;

    /**
     * @var integer
     *
     * @ORM\Column(name="tempo_horas_uteis", type="bigint", nullable=true)
     */
    private $tempoHorasUteis;

    /**
     * @var string
     *
     * @ORM\Column(name="faixa_hh_uteis", type="string", length=10, nullable=true)
     */
    private $faixaHhUteis;



    /**
     * Get idTemporeacao
     *
     * @return integer
     */
    public function getIdTemporeacao()
    {
        return $this->idTemporeacao;
    }

    /**
     * Set idCanal
     *
     * @param integer $idCanal
     *
     * @return Temporeacao
     */
    public function setIdCanal($idCanal)
    {
        $this->idCanal = $idCanal;

        return $this;
    }

    /**
     * Get idCanal
     *
     * @return integer
     */
    public function getIdCanal()
    {
        return $this->idCanal;
    }

    /**
     * Set idConversa
     *
     * @param integer $idConversa
     *
     * @return Temporeacao
     */
    public function setIdConversa($idConversa)
    {
        $this->idConversa = $idConversa;

        return $this;
    }

    /**
     * Get idConversa
     *
     * @return integer
     */
    public function getIdConversa()
    {
        return $this->idConversa;
    }

    /**
     * Set idPost
     *
     * @param integer $idPost
     *
     * @return Temporeacao
     */
    public function setIdPost($idPost)
    {
        $this->idPost = $idPost;

        return $this;
    }

    /**
     * Get idPost
     *
     * @return integer
     */
    public function getIdPost()
    {
        return $this->idPost;
    }

    /**
     * Set tempoMinutosBrutos
     *
     * @param integer $tempoMinutosBrutos
     *
     * @return Temporeacao
     */
    public function setTempoMinutosBrutos($tempoMinutosBrutos)
    {
        $this->tempoMinutosBrutos = $tempoMinutosBrutos;

        return $this;
    }

    /**
     * Get tempoMinutosBrutos
     *
     * @return integer
     */
    public function getTempoMinutosBrutos()
    {
        return $this->tempoMinutosBrutos;
    }

    /**
     * Set tempoHorasUteis
     *
     * @param integer $tempoHorasUteis
     *
     * @return Temporeacao
     */
    public function setTempoHorasUteis($tempoHorasUteis)
    {
        $this->tempoHorasUteis = $tempoHorasUteis;

        return $this;
    }

    /**
     * Get tempoHorasUteis
     *
     * @return integer
     */
    public function getTempoHorasUteis()
    {
        return $this->tempoHorasUteis;
    }

    /**
     * Set faixaHhUteis
     *
     * @param string $faixaHhUteis
     *
     * @return Temporeacao
     */
    public function setFaixaHhUteis($faixaHhUteis)
    {
        $this->faixaHhUteis = $faixaHhUteis;

        return $this;
    }

    /**
     * Get faixaHhUteis
     *
     * @return string
     */
    public function getFaixaHhUteis()
    {
        return $this->faixaHhUteis;
    }
}
