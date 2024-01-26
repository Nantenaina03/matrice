<?php

namespace App\Entity;

use App\Repository\QuotpartRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuotpartRepository::class)]
class Quotpart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $pr = null;

    #[ORM\Column(nullable: true)]
    private ?int $pt = null;

    #[ORM\Column(nullable: true)]
    private ?int $nic = null;

    #[ORM\Column(nullable: true)]
    private ?int $i = null;

    #[ORM\Column(nullable: true)]
    private ?int $total = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPr(): ?int
    {
        return $this->pr;
    }

    public function setPr(?int $pr): static
    {
        $this->pr = $pr;

        return $this;
    }

    public function getPt(): ?int
    {
        return $this->pt;
    }

    public function setPt(?int $pt): static
    {
        $this->pt = $pt;

        return $this;
    }

    public function getNic(): ?int
    {
        return $this->nic;
    }

    public function setNic(?int $nic): static
    {
        $this->nic = $nic;

        return $this;
    }

    public function getI(): ?int
    {
        return $this->i;
    }

    public function setI(?int $i): static
    {
        $this->i = $i;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(?int $total): static
    {
        $this->total = $total;

        return $this;
    }
}
