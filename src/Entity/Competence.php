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

    #[ORM\Column(length: 100, unique: true)]
    private ?string $libelle = null;

    /** @var Collection<int, Salarie> */
    #[ORM\ManyToMany(targetEntity: Salarie::class, mappedBy: 'competences')]
    private Collection $salaries;

    public function __construct()
    {
        $this->salaries = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getLibelle(): ?string { return $this->libelle; }
    public function setLibelle(string $libelle): static { $this->libelle = $libelle; return $this; }

    /** @return Collection<int, Salarie> */
    public function getSalaries(): Collection { return $this->salaries; }

    public function __toString(): string { return (string) $this->libelle; }
}
