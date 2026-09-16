<?php

namespace App\Entity;

use App\Repository\SalarieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SalarieRepository::class)]
#[ORM\Table(name: 'salarie')]
#[UniqueEntity(fields: ['email'], message: 'Cet email est déjà utilisé par un autre salarié.')]
class Salarie
{
    public const CIVILITES = ['Monsieur', 'Madame'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_salarie')]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    private ?string $prenom = null;

    #[ORM\Column(length: 8)]
    #[Assert\Choice(choices: self::CIVILITES)]
    private ?string $civilite = null;

    #[ORM\Column(length: 150, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(name: 'code_postal', length: 10, nullable: true)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ville = null;

    #[ORM\ManyToOne(targetEntity: Site::class, inversedBy: 'salaries')]
    #[ORM\JoinColumn(name: 'id_site', referencedColumnName: 'id_site', nullable: false)]
    #[Assert\NotNull]
    private ?Site $site = null;

    /** @var Collection<int, Competence> */
    #[ORM\ManyToMany(targetEntity: Competence::class, inversedBy: 'salaries')]
    #[ORM\JoinTable(name: 'posseder')]
    #[ORM\JoinColumn(name: 'id_salarie', referencedColumnName: 'id_salarie', onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'id_competence', referencedColumnName: 'id_competence', onDelete: 'CASCADE')]
    private Collection $competences;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $nom): static { $this->nom = $nom; return $this; }

    public function getPrenom(): ?string { return $this->prenom; }
    public function setPrenom(string $prenom): static { $this->prenom = $prenom; return $this; }

    public function getCivilite(): ?string { return $this->civilite; }
    public function setCivilite(string $civilite): static { $this->civilite = $civilite; return $this; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): static { $this->email = $email; return $this; }

    public function getTelephone(): ?string { return $this->telephone; }
    public function setTelephone(?string $telephone): static { $this->telephone = $telephone; return $this; }

    public function getAdresse(): ?string { return $this->adresse; }
    public function setAdresse(?string $adresse): static { $this->adresse = $adresse; return $this; }

    public function getCodePostal(): ?string { return $this->codePostal; }
    public function setCodePostal(?string $codePostal): static { $this->codePostal = $codePostal; return $this; }

    public function getVille(): ?string { return $this->ville; }
    public function setVille(?string $ville): static { $this->ville = $ville; return $this; }

    public function getSite(): ?Site { return $this->site; }
    public function setSite(?Site $site): static { $this->site = $site; return $this; }

    /** @return Collection<int, Competence> */
    public function getCompetences(): Collection { return $this->competences; }

    public function addCompetence(Competence $competence): static
    {
        if (!$this->competences->contains($competence)) {
            $this->competences->add($competence);
        }
        return $this;
    }

    public function removeCompetence(Competence $competence): static
    {
        $this->competences->removeElement($competence);
        return $this;
    }
}
