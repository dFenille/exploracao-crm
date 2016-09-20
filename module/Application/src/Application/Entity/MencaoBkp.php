<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MencaoBkp
 *
 * @ORM\Table(name="mencao_bkp")
 * @ORM\Entity
 */
class MencaoBkp
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_mencao_aux", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMencaoAux;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_monitoring", type="integer", nullable=false)
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
     * @ORM\Column(name="mensagem", type="text", length=16, nullable=true)
     */
    private $mensagem;

    /**
     * @var string
     *
     * @ORM\Column(name="sentimento", type="string", length=20, nullable=true)
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
     * @ORM\Column(name="dt_proccess", type="datetime", nullable=true)
     */
    private $dtProccess;

    /**
     * @var integer
     *
     * @ORM\Column(name="cod_mens", type="integer", nullable=true)
     */
    private $codMens;



    /**
     * Get idMencaoAux
     *
     * @return integer
     */
    public function getIdMencaoAux()
    {
        return $this->idMencaoAux;
    }

    /**
     * Set idMonitoring
     *
     * @param integer $idMonitoring
     *
     * @return MencaoBkp
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
     * @return MencaoBkp
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
     * @return MencaoBkp
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
     * @return MencaoBkp
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
     * @return MencaoBkp
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
     * @return MencaoBkp
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
     * @return MencaoBkp
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
     * @return MencaoBkp
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
     * @return MencaoBkp
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
     * @return MencaoBkp
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
     * Set dtProccess
     *
     * @param \DateTime $dtProccess
     *
     * @return MencaoBkp
     */
    public function setDtProccess($dtProccess)
    {
        $this->dtProccess = $dtProccess;

        return $this;
    }

    /**
     * Get dtProccess
     *
     * @return \DateTime
     */
    public function getDtProccess()
    {
        return $this->dtProccess;
    }

    /**
     * Set codMens
     *
     * @param integer $codMens
     *
     * @return MencaoBkp
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
