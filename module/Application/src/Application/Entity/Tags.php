<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tags
 *
 * @ORM\Table(name="tags")
 * @ORM\Entity
 */
class Tags
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_tag", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTag;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_tag_action", type="bigint", nullable=true)
     */
    private $idTagAction;

    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string", length=200, nullable=true)
     */
    private $tag;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_monitoring", type="integer", nullable=true)
     */
    private $idMonitoring;



    /**
     * Get idTag
     *
     * @return integer
     */
    public function getIdTag()
    {
        return $this->idTag;
    }

    /**
     * Set idTagAction
     *
     * @param integer $idTagAction
     *
     * @return Tags
     */
    public function setIdTagAction($idTagAction)
    {
        $this->idTagAction = $idTagAction;

        return $this;
    }

    /**
     * Get idTagAction
     *
     * @return integer
     */
    public function getIdTagAction()
    {
        return $this->idTagAction;
    }

    /**
     * Set tag
     *
     * @param string $tag
     *
     * @return Tags
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set idMonitoring
     *
     * @param integer $idMonitoring
     *
     * @return Tags
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
}
