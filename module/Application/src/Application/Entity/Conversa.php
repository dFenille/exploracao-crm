<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conversa
 *
 * @ORM\Table(name="Conversa", indexes={@ORM\Index(name="id_mention", columns={"id_mention"}), @ORM\Index(name="idUser", columns={"idUser"}), @ORM\Index(name="dt_coleta", columns={"dt_coleta"}), @ORM\Index(name="dt_process", columns={"dt_process"}), @ORM\Index(name="TipoConversa", columns={"tipoConversa"})})
 * @ORM\Entity
 */
class Conversa
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_conversa", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idConversa;

    /**
     * @var integer
     *
     * @ORM\Column(name="parent_id", type="bigint", nullable=true)
     */
    private $parentId;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_mention", type="bigint", nullable=true)
     */
    private $idMention;

    /**
     * @var integer
     *
     * @ORM\Column(name="idUser", type="bigint", nullable=true)
     */
    private $iduser;

    /**
     * @var integer
     *
     * @ORM\Column(name="idCanal", type="integer", nullable=true)
     */
    private $idcanal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_coleta", type="datetime", nullable=true)
     */
    private $dtColeta;

    /**
     * @var integer
     *
     * @ORM\Column(name="ticket_id", type="bigint", nullable=true)
     */
    private $ticketId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_process", type="datetime", nullable=true)
     */
    private $dtProcess;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipoConversa", type="smallint", nullable=true)
     */
    private $tipoconversa;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint", nullable=true)
     */
    private $status;



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
     * Set parentId
     *
     * @param integer $parentId
     *
     * @return Conversa
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
     * Set idMention
     *
     * @param integer $idMention
     *
     * @return Conversa
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
     * Set iduser
     *
     * @param integer $iduser
     *
     * @return Conversa
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return integer
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * Set idcanal
     *
     * @param integer $idcanal
     *
     * @return Conversa
     */
    public function setIdcanal($idcanal)
    {
        $this->idcanal = $idcanal;

        return $this;
    }

    /**
     * Get idcanal
     *
     * @return integer
     */
    public function getIdcanal()
    {
        return $this->idcanal;
    }

    /**
     * Set dtColeta
     *
     * @param \DateTime $dtColeta
     *
     * @return Conversa
     */
    public function setDtColeta($dtColeta)
    {
        $this->dtColeta = $dtColeta;

        return $this;
    }

    /**
     * Get dtColeta
     *
     * @return \DateTime
     */
    public function getDtColeta()
    {
        return $this->dtColeta;
    }

    /**
     * Set ticketId
     *
     * @param integer $ticketId
     *
     * @return Conversa
     */
    public function setTicketId($ticketId)
    {
        $this->ticketId = $ticketId;

        return $this;
    }

    /**
     * Get ticketId
     *
     * @return integer
     */
    public function getTicketId()
    {
        return $this->ticketId;
    }

    /**
     * Set dtProcess
     *
     * @param \DateTime $dtProcess
     *
     * @return Conversa
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
     * Set tipoconversa
     *
     * @param integer $tipoconversa
     *
     * @return Conversa
     */
    public function setTipoconversa($tipoconversa)
    {
        $this->tipoconversa = $tipoconversa;

        return $this;
    }

    /**
     * Get tipoconversa
     *
     * @return integer
     */
    public function getTipoconversa()
    {
        return $this->tipoconversa;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Conversa
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }
}
