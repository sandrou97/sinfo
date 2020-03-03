<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TallerRepository")
 */
class Taller
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
    private $titulota;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categoriataller")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoriataller;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $liketa;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitulota(): ?string
    {
        return $this->titulota;
    }

    public function setTitulota(?string $titulota): self
    {
        $this->titulota = $titulota;

        return $this;
    }

    public function getCategoriataller(): ?Categoriataller
    {
        return $this->categoriataller;
    }

    public function setCategoriataller(?Categoriataller $categoriataller): self
    {
        $this->categoriataller = $categoriataller;

        return $this;
    }

    public function getLiketa(): ?int
    {
        return $this->liketa;
    }

    public function setLiketa(?int $liketa): self
    {
        $this->liketa = $liketa;

        return $this;
    }

    public function setLiketaup(): self
    {
        $this->liketa++;

        return $this;
    }

    public function setLiketaminus(): self
    {
        $this->liketa--;

        return $this;
    }
}
