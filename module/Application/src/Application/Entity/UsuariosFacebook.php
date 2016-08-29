<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuariosFacebook
 *
 * @ORM\Table(name="usuarios_facebook")
 * @ORM\Entity
 */
class UsuariosFacebook
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_usuarios_facebook", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUsuariosFacebook;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_facebook", type="bigint", nullable=true)
     */
    private $idFacebook;

    /**
     * @var string
     *
     * @ORM\Column(name="foto_usuario", type="string", length=0, nullable=true)
     */
    private $fotoUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=70, nullable=true)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="documento", type="string", length=100, nullable=true)
     */
    private $documento;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=200, nullable=true)
     */
    private $descricao;

    /**
     * @var string
     *
     * @ORM\Column(name="localizacao", type="string", length=100, nullable=true)
     */
    private $localizacao;



    /**
     * Get idUsuariosFacebook
     *
     * @return integer
     */
    public function getIdUsuariosFacebook()
    {
        return $this->idUsuariosFacebook;
    }

    /**
     * Set idFacebook
     *
     * @param integer $idFacebook
     *
     * @return UsuariosFacebook
     */
    public function setIdFacebook($idFacebook)
    {
        $this->idFacebook = $idFacebook;

        return $this;
    }

    /**
     * Get idFacebook
     *
     * @return integer
     */
    public function getIdFacebook()
    {
        return $this->idFacebook;
    }

    /**
     * Set fotoUsuario
     *
     * @param string $fotoUsuario
     *
     * @return UsuariosFacebook
     */
    public function setFotoUsuario($fotoUsuario)
    {
        $this->fotoUsuario = $fotoUsuario;

        return $this;
    }

    /**
     * Get fotoUsuario
     *
     * @return string
     */
    public function getFotoUsuario()
    {
        return $this->fotoUsuario;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return UsuariosFacebook
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return UsuariosFacebook
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set documento
     *
     * @param string $documento
     *
     * @return UsuariosFacebook
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return string
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     *
     * @return UsuariosFacebook
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set localizacao
     *
     * @param string $localizacao
     *
     * @return UsuariosFacebook
     */
    public function setLocalizacao($localizacao)
    {
        $this->localizacao = $localizacao;

        return $this;
    }

    /**
     * Get localizacao
     *
     * @return string
     */
    public function getLocalizacao()
    {
        return $this->localizacao;
    }
}
