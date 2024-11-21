<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $id_categorie = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Emplacement $id_emplacement = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etat $id_etat = null;

    /**
     * @var Collection<int, Historique>
     */
    #[ORM\OneToMany(targetEntity: Historique::class, mappedBy: 'produit')]
    private Collection $historiques;

    /**
     * @var Collection<int, Reparations>
     */
    #[ORM\OneToMany(targetEntity: Reparations::class, mappedBy: 'produit')]
    private Collection $reparations;

    public function __construct()
    {
        $this->historiques = new ArrayCollection();
        $this->reparations = new ArrayCollection();
    }

   
    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdCategorie(): ?Categorie
    {
        return $this->id_categorie;
    }

    public function setIdCategorie(?Categorie $id_categorie): static
    {
        $this->id_categorie = $id_categorie;

        return $this;
    }

    public function getIdEmplacement(): ?Emplacement
    {
        return $this->id_emplacement;
    }

    public function setIdEmplacement(?Emplacement $id_emplacement): static
    {
        $this->id_emplacement = $id_emplacement;

        return $this;
    }

    public function getIdEtat(): ?Etat
    {
        return $this->id_etat;
    }

    public function setIdEtat(?Etat $id_etat): static
    {
        $this->id_etat = $id_etat;

        return $this;
    }

    /**
     * @return Collection<int, Historique>
     */
    public function getHistoriques(): Collection
    {
        return $this->historiques;
    }

    public function addHistorique(Historique $historique): static
    {
        if (!$this->historiques->contains($historique)) {
            $this->historiques->add($historique);
            $historique->setProduit($this);
        }

        return $this;
    }

    public function removeHistorique(Historique $historique): static
    {
        if ($this->historiques->removeElement($historique)) {
            // set the owning side to null (unless already changed)
            if ($historique->getProduit() === $this) {
                $historique->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reparations>
     */
    public function getReparations(): Collection
    {
        return $this->reparations;
    }

    public function addReparation(Reparations $reparation): static
    {
        if (!$this->reparations->contains($reparation)) {
            $this->reparations->add($reparation);
            $reparation->setProduit($this);
        }

        return $this;
    }

    public function removeReparation(Reparations $reparation): static
    {
        if ($this->reparations->removeElement($reparation)) {
            // set the owning side to null (unless already changed)
            if ($reparation->getProduit() === $this) {
                $reparation->setProduit(null);
            }
        }

        return $this;
    }

    
}
