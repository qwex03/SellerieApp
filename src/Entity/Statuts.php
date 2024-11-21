<?php

namespace App\Entity;

use App\Repository\StatutsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatutsRepository::class)]
class Statuts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    /**
     * @var Collection<int, Reparations>
     */
    #[ORM\OneToMany(targetEntity: Reparations::class, mappedBy: 'status')]
    private Collection $reparations;

    public function __construct()
    {
        $this->reparations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

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
            $reparation->setStatus($this);
        }

        return $this;
    }

    public function removeReparation(Reparations $reparation): static
    {
        if ($this->reparations->removeElement($reparation)) {
            // set the owning side to null (unless already changed)
            if ($reparation->getStatus() === $this) {
                $reparation->setStatus(null);
            }
        }

        return $this;
    }
}
