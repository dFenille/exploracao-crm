<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mencao
 *
 * @ORM\Table(name="mencao", indexes={@ORM\Index(name="parent_id", columns={"parent_id"}), @ORM\Index(name="id_mention", columns={"id_mention"}), @ORM\Index(name="sentimento", columns={"sentimento"}), @ORM\Index(name="dt_envio", columns={"dt_envio"}), @ORM\Index(name="tipo_captura", columns={"tipo_captura"})})
 * @ORM\Entity
 */
class Mencao
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_mencao", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMencao;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_mention", type="bigint", nullable=false)
     */
    private $idMention;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_monitoring", type="integer", nullable=true)
     */
    private $idMonitoring;

    /**
     * @var integer
     *
     * @ORM\Column(name="parent_id", type="bigint", nullable=true)
     */
    private $parentId;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_usuario_facebook", type="integer", nullable=true)
     */
    private $idUsuarioFacebook;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_usuario_instagram", type="integer", nullable=true)
     */
    private $idUsuarioInstagram;

    /**
     * @var string
     *
     * @ORM\Column(name="mensagem", type="string", length=3000, nullable=true)
     */
    private $mensagem;

    /**
     * @var string
     *
     * @ORM\Column(name="sentimento", type="string", length=50, nullable=true)
     */
    private $sentimento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_envio", type="datetime", nullable=true)
     */
    private $dtEnvio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_coleta_scup", type="datetime", nullable=true)
     */
    private $dtColetaScup;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_captura", type="string", length=50, nullable=true)
     */
    private $tipoCaptura;

    /**
     * @var string
     *
     * @ORM\Column(name="permalink", type="string", length=300, nullable=true)
     */
    private $permalink;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_process", type="datetime", nullable=true)
     */
    private $dtProcess;

    /**
     * @var integer
     *
     * @ORM\Column(name="cod_mens", type="integer", nullable=true)
     */
    private $codMens;



    /**
     * Get idMencao
     *
     * @return integer
     */
    public function getIdMencao()
    {
        return $this->idMencao;
    }

    /**
     * Set idMention
     *
     * @param integer $idMention
     *
     * @return Mencao
     */
    public function setIdMention($idMention)
    {
        $this->idMention = $idMention;

        return $this;
    }

    /**
     * Get idMention
     *
     * @return integer
     */
    public function getIdMention()
    {
        return $this->idMention;
    }

    /**
     * Set idMonitoring
     *
     * @param integer $idMonitoring
     *
     * @return Mencao
     */
    public function setIdMonitoring($idMonitoring)
    {
        $this->idMonitoring = $idMonitoring;

        return $this;
    }

    /**
     * Get idMonitoring
     *
     * @return integer
     */
    public function getIdMonitoring()
    {
        return $this->idMonitoring;
    }

    /**
     * Set parentId
     *
     * @param integer $parentId
     *
     * @return Mencao
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set idUsuarioFacebook
     *
     * @param integer $idUsuarioFacebook
     *
     * @return Mencao
     */
    public function setIdUsuarioFacebook($idUsuarioFacebook)
    {
        $this->idUsuarioFacebook = $idUsuarioFacebook;

        return $this;
    }

    /**
     * Get idUsuarioFacebook
     *
     * @return integer
     */
    public function getIdUsuarioFacebook()
    {
        return $this->idUsuarioFacebook;
    }

    /**
     * Set idUsuarioInstagram
     *
     * @param integer $idUsuarioInstagram
     *
     * @return Mencao
     */
    public function setIdUsuarioInstagram($idUsuarioInstagram)
    {
        $this->idUsuarioInstagram = $idUsuarioInstagram;

        return $this;
    }

    /**
     * Get idUsuarioInstagram
     *
     * @return integer
     */
    public function getIdUsuarioInstagram()
    {
        return $this->idUsuarioInstagram;
    }

    /**
     * Set mensagem
     *
     * @param string $mensagem
     *
     * @return Mencao
     */
    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;

        return $this;
    }

    /**
     * Get mensagem
     *
     * @return string
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * Set sentimento
     *
     * @param string $sentimento
     *
     * @return Mencao
     */
    public function setSentimento($sentimento)
    {
        $this->sentimento = $sentimento;

        return $this;
    }

    /**
     * Get sentimento
     *
     * @return string
     */
    public function getSentimento()
    {
        return $this->sentimento;
    }

    /**
     * Set dtEnvio
     *
     * @param \DateTime $dtEnvio
     *
     * @return Mencao
     */
    public function setDtEnvio($dtEnvio)
    {
        $this->dtEnvio = $dtEnvio;

        return $this;
    }

    /**
     * Get dtEnvio
     *
     * @return \DateTime
     */
    public function getDtEnvio()
    {
        return $this->dtEnvio;
    }

    /**
     * Set dtColetaScup
     *
     * @param \DateTime $dtColetaScup
     *
     * @return Mencao
     */
    public function setDtColetaScup($dtColetaScup)
    {
        $this->dtColetaScup = $dtColetaScup;

        return $this;
    }

    /**
     * Get dtColetaScup
     *
     * @return \DateTime
     */
    public function getDtColetaScup()
    {
        return $this->dtColetaScup;
    }

    /**
     * Set tipoCaptura
     *
     * @param string $tipoCaptura
     *
     * @return Mencao
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

    /**
     * Set permalink
     *
     * @param string $permalink
     *
     * @return Mencao
     */
    public function setPermalink($permalink)
    {
        $this->permalink = $permalink;

        return $this;
    }

    /**
     * Get permalink
     *
     * @return string
     */
    public function getPermalink()
    {
        return $this->permalink;
    }

    /**
     * Set dtProcess
     *
     * @param \DateTime $dtProcess
     *
     * @return Mencao
     */
    public function setDtProcess($dtProcess)
    {
        $this->dtProcess = $dtProcess;

        return $this;
    }

    /**
     * Get dtProcess
     *
     * @return \DateTime
     */
    public function getDtProcess()
    {
        return $this->dtProcess;
    }

    /**
     * Set codMens
     *
     * @param integer $codMens
     *
     * @return Mencao
     */
    public function setCodMens($codMens)
    {
        $this->codMens = $codMens;

        return $this;
    }

    /**
     * Get codMens
     *
     * @return integer
     */
    public function getCodMens()
    {
        return $this->codMens;
    }
}
