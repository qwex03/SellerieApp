<?php

namespace App\Entity;

use App\Repository\ReparationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReparationsRepository::class)]
class Reparations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reparations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $produit = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_signalement = null;

    #[ORM\ManyToOne(inversedBy: 'reparations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Statuts $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getDateSignalement(): ?\DateTimeInterface
    {
        return $this->date_signalement;
    }

    public function setDateSignalement(\DateTimeInterface $date_signalement): static
    {
        $this->date_signalement = $date_signalement;

        return $this;
    }

    public function getStatus(): ?Statuts
    {
        return $this->status;
    }

    public function setStatus(?Statuts $status): static
    {
        $this->status = $status;

        return $this;
    }
}
