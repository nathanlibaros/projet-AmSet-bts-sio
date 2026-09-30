<?php

namespace App\Entity;

use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompetenceRepository::class)]
#[ORM\Table(name: 'competence')]
class Competence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_competence')]
    private ?int $id = null;

    /**
     * Libellé de référence (français). Sert aussi si une traduction manque.
     */
    #[ORM\Column(length: 100, unique: true)]
    private ?string $libelle = null;

    /** @var Collection<int, Salarie> */
    #[ORM\ManyToMany(targetEntity: Salarie::class, mappedBy: 'competences')]
    private Collection $salaries;

    /** @var Collection<int, CompetenceTraduction> */
    #[ORM\OneToMany(targetEntity: CompetenceTraduction::class, mappedBy: 'competence', cascade: ['persist', 'remove'])]
    private Collection $traductions;

    public function __construct()
    {
        $this->salaries = new ArrayCollection();
        $this->traductions = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getLibelle(): ?string { return $this->libelle; }
    public function setLibelle(string $libelle): static { $this->libelle = $libelle; return $this; }

    /** @return Collection<int, Salarie> */
    public function getSalaries(): Collection { return $this->salaries; }

    /** @return Collection<int, CompetenceTraduction> */
    public function getTraductions(): Collection { return $this->traductions; }

    public function addTraduction(CompetenceTraduction $traduction): static
    {
        if (!$this->traductions->contains($traduction)) {
            $this->traductions->add($traduction);
            $traduction->setCompetence($this);
        }
        return $this;
    }

    public function removeTraduction(CompetenceTraduction $traduction): static
    {
        $this->traductions->removeElement($traduction);
        return $this;
    }

    /**
     * Libellé dans la langue demandée ; si la traduction n'existe pas,
     * on retombe sur le libellé de référence.
     */
    public function getLibelleTraduit(string $codeLangue): string
    {
        foreach ($this->traductions as $traduction) {
            if ($traduction->getLangue()?->getCode() === $codeLangue) {
                return $traduction->getLibelle();
            }
        }

        return (string) $this->libelle;
    }

    public function __toString(): string { return (string) $this->libelle; }
}
