<?php

namespace App\Entity;

use App\Repository\BestellungRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BestellungRepository::class)]
class Bestellung
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $tisch;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $bnummer;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $name;

    #[ORM\Column(type: 'float', nullable: true)]
    private $preis;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTisch(): ?string
    {
        return $this->tisch;
    }

    public function setTisch(?string $tisch): self
    {
        $this->tisch = $tisch;

        return $this;
    }

    public function getBnummer(): ?string
    {
        return $this->bnummer;
    }

    public function setBnummer(?string $bnummer): self
    {
        $this->bnummer = $bnummer;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPreis(): ?float
    {
        return $this->preis;
    }

    public function setPreis(?float $preis): self
    {
        $this->preis = $preis;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
