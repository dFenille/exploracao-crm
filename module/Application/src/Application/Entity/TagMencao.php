<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TagMencao
 *
 * @ORM\Table(name="tag_mencao", indexes={@ORM\Index(name="id_mencao", columns={"id_mencao"}), @ORM\Index(name="IDX_8DB8DF509D2D5FD9", columns={"id_tag"})})
 * @ORM\Entity
 */
class TagMencao
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_tag_mencao", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTagMencao;

    /**
     * @var \Application\Entity\Tags
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Tags")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tag", referencedColumnName="id_tag")
     * })
     */
    private $idTag;

    /**
     * @var \Application\Entity\Mencao
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Mencao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_mencao", referencedColumnName="id_mencao")
     * })
     */
    private $idMencao;



    /**
     * Get idTagMencao
     *
     * @return integer
     */
    public function getIdTagMencao()
    {
        return $this->idTagMencao;
    }

    /**
     * Set idTag
     *
     * @param \Application\Entity\Tags $idTag
     *
     * @return TagMencao
     */
    public function setIdTag(\Application\Entity\Tags $idTag = null)
    {
        $this->idTag = $idTag;

        return $this;
    }

    /**
     * Get idTag
     *
     * @return \Application\Entity\Tags
     */
    public function getIdTag()
    {
        return $this->idTag;
    }

    /**
     * Set idMencao
     *
     * @param \Application\Entity\Mencao $idMencao
     *
     * @return TagMencao
     */
    public function setIdMencao(\Application\Entity\Mencao $idMencao = null)
    {
        $this->idMencao = $idMencao;

        return $this;
    }

    /**
     * Get idMencao
     *
     * @return \Application\Entity\Mencao
     */
    public function getIdMencao()
    {
        return $this->idMencao;
    }
}
