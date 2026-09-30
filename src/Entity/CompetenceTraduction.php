<?php

namespace App\Entity;

use App\Repository\CompetenceTraductionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Libellé d'une compétence dans une langue donnée.
 * Pour ajouter une langue, il suffit d'ajouter des lignes ici.
 */
#[ORM\Entity(repositoryClass: CompetenceTraductionRepository::class)]
#[ORM\Table(name: 'competence_traduction')]
class CompetenceTraduction
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Competence::class, inversedBy: 'traductions')]
    #[ORM\JoinColumn(name: 'id_competence', referencedColumnName: 'id_competence', nullable: false, onDelete: 'CASCADE')]
    private ?Competence $competence = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Langue::class)]
    #[ORM\JoinColumn(name: 'code_langue', referencedColumnName: 'code_langue', nullable: false, onDelete: 'CASCADE')]
    private ?Langue $langue = null;

    #[ORM\Column(length: 100)]
    private ?string $libelle = null;

    public function getCompetence(): ?Competence { return $this->competence; }
    public function setCompetence(?Competence $competence): static { $this->competence = $competence; return $this; }

    public function getLangue(): ?Langue { return $this->langue; }
    public function setLangue(?Langue $langue): static { $this->langue = $langue; return $this; }

    public function getLibelle(): ?string { return $this->libelle; }
    public function setLibelle(string $libelle): static { $this->libelle = $libelle; return $this; }
}
