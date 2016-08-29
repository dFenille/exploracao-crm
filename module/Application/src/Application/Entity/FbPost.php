<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FbPost
 *
 * @ORM\Table(name="fb_post")
 * @ORM\Entity
 */
class FbPost
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_fb", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFb;

    /**
     * @var string
     *
     * @ORM\Column(name="id_fb_post", type="string", length=50, nullable=true)
     */
    private $idFbPost;

    /**
     * @var string
     *
     * @ORM\Column(name="id_fb_user", type="string", length=50, nullable=true)
     */
    private $idFbUser;

    /**
     * @var string
     *
     * @ORM\Column(name="id_fb_type", type="string", length=50, nullable=true)
     */
    private $idFbType;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", length=16, nullable=true)
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_time", type="datetime", nullable=true)
     */
    private $createdTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_time", type="datetime", nullable=true)
     */
    private $updatedTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_process", type="datetime", nullable=true)
     */
    private $dtProcess;



    /**
     * Get idFb
     *
     * @return integer
     */
    public function getIdFb()
    {
        return $this->idFb;
    }

    /**
     * Set idFbPost
     *
     * @param string $idFbPost
     *
     * @return FbPost
     */
    public function setIdFbPost($idFbPost)
    {
        $this->idFbPost = $idFbPost;

        return $this;
    }

    /**
     * Get idFbPost
     *
     * @return string
     */
    public function getIdFbPost()
    {
        return $this->idFbPost;
    }

    /**
     * Set idFbUser
     *
     * @param string $idFbUser
     *
     * @return FbPost
     */
    public function setIdFbUser($idFbUser)
    {
        $this->idFbUser = $idFbUser;

        return $this;
    }

    /**
     * Get idFbUser
     *
     * @return string
     */
    public function getIdFbUser()
    {
        return $this->idFbUser;
    }

    /**
     * Set idFbType
     *
     * @param string $idFbType
     *
     * @return FbPost
     */
    public function setIdFbType($idFbType)
    {
        $this->idFbType = $idFbType;

        return $this;
    }

    /**
     * Get idFbType
     *
     * @return string
     */
    public function getIdFbType()
    {
        return $this->idFbType;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return FbPost
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     *
     * @return FbPost
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;

        return $this;
    }

    /**
     * Get createdTime
     *
     * @return \DateTime
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * Set updatedTime
     *
     * @param \DateTime $updatedTime
     *
     * @return FbPost
     */
    public function setUpdatedTime($updatedTime)
    {
        $this->updatedTime = $updatedTime;

        return $this;
    }

    /**
     * Get updatedTime
     *
     * @return \DateTime
     */
    public function getUpdatedTime()
    {
        return $this->updatedTime;
    }

    /**
     * Set dtProcess
     *
     * @param \DateTime $dtProcess
     *
     * @return FbPost
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
}
