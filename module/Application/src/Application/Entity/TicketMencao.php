<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TicketMencao
 *
 * @ORM\Table(name="ticket_mencao", indexes={@ORM\Index(name="id_mention", columns={"id_mention"})})
 * @ORM\Entity
 */
class TicketMencao
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_tickets_mencao", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTicketsMencao;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_mention", type="bigint", nullable=true)
     */
    private $idMention;

    /**
     * @var integer
     *
     * @ORM\Column(name="ticket_id", type="bigint", nullable=true)
     */
    private $ticketId;

    /**
     * @var integer
     *
     * @ORM\Column(name="assinatura_id", type="bigint", nullable=true)
     */
    private $assinaturaId;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=60, nullable=true)
     */
    private $status;



    /**
     * Get idTicketsMencao
     *
     * @return integer
     */
    public function getIdTicketsMencao()
    {
        return $this->idTicketsMencao;
    }

    /**
     * Set idMention
     *
     * @param integer $idMention
     *
     * @return TicketMencao
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
     * Set ticketId
     *
     * @param integer $ticketId
     *
     * @return TicketMencao
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
     * Set assinaturaId
     *
     * @param integer $assinaturaId
     *
     * @return TicketMencao
     */
    public function setAssinaturaId($assinaturaId)
    {
        $this->assinaturaId = $assinaturaId;

        return $this;
    }

    /**
     * Get assinaturaId
     *
     * @return integer
     */
    public function getAssinaturaId()
    {
        return $this->assinaturaId;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return TicketMencao
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
