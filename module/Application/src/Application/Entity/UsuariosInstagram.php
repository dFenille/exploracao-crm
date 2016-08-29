<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuariosInstagram
 *
 * @ORM\Table(name="usuarios_instagram")
 * @ORM\Entity
 */
class UsuariosInstagram
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_usuarios_instagram", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUsuariosInstagram;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_instagram", type="bigint", nullable=false)
     */
    private $idInstagram;

    /**
     * @var string
     *
     * @ORM\Column(name="foto_perfil", type="string", length=300, nullable=true)
     */
    private $fotoPerfil;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=100, nullable=true)
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
     * Get idUsuariosInstagram
     *
     * @return integer
     */
    public function getIdUsuariosInstagram()
    {
        return $this->idUsuariosInstagram;
    }

    /**
     * Set idInstagram
     *
     * @param integer $idInstagram
     *
     * @return UsuariosInstagram
     */
    public function setIdInstagram($idInstagram)
    {
        $this->idInstagram = $idInstagram;

        return $this;
    }

    /**
     * Get idInstagram
     *
     * @return integer
     */
    public function getIdInstagram()
    {
        return $this->idInstagram;
    }

    /**
     * Set fotoPerfil
     *
     * @param string $fotoPerfil
     *
     * @return UsuariosInstagram
     */
    public function setFotoPerfil($fotoPerfil)
    {
        $this->fotoPerfil = $fotoPerfil;

        return $this;
    }

    /**
     * Get fotoPerfil
     *
     * @return string
     */
    public function getFotoPerfil()
    {
        return $this->fotoPerfil;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return UsuariosInstagram
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
     * @return UsuariosInstagram
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
     * @return UsuariosInstagram
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
     * @return UsuariosInstagram
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
     * @return UsuariosInstagram
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
