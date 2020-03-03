<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PonenciaRepository")
 */
class Ponencia
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titulopo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categoriaponencia")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoriaponencia;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $likepo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?Int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitulopo(): ?string
    {
        return $this->titulopo;
    }

    public function setTitulopo(?string $titulopo): self
    {
        $this->titulopo = $titulopo;

        return $this;
    }

    public function getCategoriaponencia(): ?Categoriaponencia
    {
        return $this->categoriaponencia;
    }

    public function setCategoriaponencia(?Categoriaponencia $categoriaponencia): self
    {
        $this->categoriaponencia = $categoriaponencia;

        return $this;
    }

    public function setLikepoup(): self
    {
        $this->likepo++;

        return $this;
    }

    public function setLikepominus(): self
    {
        $this->likepo--;

        return $this;
    }

    public function getLikepo(): ?int
    {
        return $this->likepo;
    }

    public function setLikepo(?int $likepo): self
    {
        $this->likepo = $likepo;

        return $this;
    }
}
