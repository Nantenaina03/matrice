<?php

namespace App\Entity;

use App\Repository\SourceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SourceRepository::class)]
class Source
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $x = null;

    #[ORM\Column(nullable: true)]
    private ?int $y = null;

    #[ORM\Column(nullable: true)]
    private ?int $z = null;

    #[ORM\Column(nullable: true)]
    private ?int $z1 = null;

    #[ORM\Column(nullable: true)]
    private ?int $n = null;

    #[ORM\Column(nullable: true)]
    private ?int $fi = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getX(): ?int
    {
        return $this->x;
    }

    public function setX(?int $x): static
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): ?int
    {
        return $this->y;
    }

    public function setY(?int $y): static
    {
        $this->y = $y;

        return $this;
    }

    public function getZ(): ?int
    {
        return $this->z;
    }

    public function setZ(?int $z): static
    {
        $this->z = $z;

        return $this;
    }

    public function getZ1(): ?int
    {
        return $this->z1;
    }

    public function setZ1(?int $z1): static
    {
        $this->z1 = $z1;

        return $this;
    }

    public function getN(): ?int
    {
        return $this->n;
    }

    public function setN(?int $n): static
    {
        $this->n = $n;

        return $this;
    }

    public function getFi(): ?int
    {
        return $this->fi;
    }

    public function setFi(?int $fi): static
    {
        $this->fi = $fi;

        return $this;
    }
}
