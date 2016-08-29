<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Posts
 *
 * @ORM\Table(name="POSTS", indexes={@ORM\Index(name="id_conversa", columns={"id_conversa"}), @ORM\Index(name="idUser", columns={"idUser"}), @ORM\Index(name="sentimento", columns={"sentimento"}), @ORM\Index(name="dt_post", columns={"dt_post"})})
 * @ORM\Entity
 */
class Posts
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_post", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPost;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_conversa", type="integer", nullable=true)
     */
    private $idConversa;

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
     * @var \DateTime
     *
     * @ORM\Column(name="dt_post", type="datetime", nullable=true)
     */
    private $dtPost;

    /**
     * @var string
     *
     * @ORM\Column(name="post", type="string", length=2000, nullable=true)
     */
    private $post = '';

    /**
     * @var string
     *
     * @ORM\Column(name="resp", type="string", length=2000, nullable=true)
     */
    private $resp = '';

    /**
     * @var string
     *
     * @ORM\Column(name="sentimento", type="string", length=20, nullable=true)
     */
    private $sentimento;

    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string", length=50, nullable=true)
     */
    private $tag;

    /**
     * @var string
     *
     * @ORM\Column(name="permalink", type="string", length=500, nullable=true)
     */
    private $permalink;



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
     * Set idConversa
     *
     * @param integer $idConversa
     *
     * @return Posts
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
     * Set idMention
     *
     * @param integer $idMention
     *
     * @return Posts
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
     * @return Posts
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
     * Set dtPost
     *
     * @param \DateTime $dtPost
     *
     * @return Posts
     */
    public function setDtPost($dtPost)
    {
        $this->dtPost = $dtPost;

        return $this;
    }

    /**
     * Get dtPost
     *
     * @return \DateTime
     */
    public function getDtPost()
    {
        return $this->dtPost;
    }

    /**
     * Set post
     *
     * @param string $post
     *
     * @return Posts
     */
    public function setPost($post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return string
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set resp
     *
     * @param string $resp
     *
     * @return Posts
     */
    public function setResp($resp)
    {
        $this->resp = $resp;

        return $this;
    }

    /**
     * Get resp
     *
     * @return string
     */
    public function getResp()
    {
        return $this->resp;
    }

    /**
     * Set sentimento
     *
     * @param string $sentimento
     *
     * @return Posts
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
     * Set tag
     *
     * @param string $tag
     *
     * @return Posts
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
     * Set permalink
     *
     * @param string $permalink
     *
     * @return Posts
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
}
