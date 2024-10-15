<?php

namespace App\Entity;

use App\Repository\HistoriqueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriqueRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Historique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date_pret = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date_retour = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'historiques')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $produit = null;

    // Constructor to initialize date_pret
    public function __construct()
    {
        $this->date_pret = new \DateTimeImmutable(); // Set to today's date by default
    }

    #[ORM\PrePersist]
    public function setDatePretAutomatically(): void
    {
        // Ensures that date_pret is set to today when the entity is persisted
        if ($this->date_pret === null) {
            $this->date_pret = new \DateTimeImmutable();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePret(): ?\DateTimeImmutable
    {
        return $this->date_pret;
    }

    public function setDatePret(\DateTimeImmutable $date_pret): static
    {
        $this->date_pret = $date_pret;

        return $this;
    }

    public function getDateRetour(): ?\DateTimeImmutable
    {
        return $this->date_retour;
    }

    public function setDateRetour(\DateTimeImmutable $date_retour): static
    {
        $this->date_retour = $date_retour;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
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
}

