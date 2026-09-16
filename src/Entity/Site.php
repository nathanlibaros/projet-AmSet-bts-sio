<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
#[ORM\Table(name: 'site')]
class Site
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_site')]
    private ?int $id = null;

    #[ORM\Column(name: 'nom_site', length: 100, unique: true)]
    private ?string $nom = null;

    /** @var Collection<int, Salarie> */
    #[ORM\OneToMany(targetEntity: Salarie::class, mappedBy: 'site')]
    private Collection $salaries;

    public function __construct()
    {
        $this->salaries = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $nom): static { $this->nom = $nom; return $this; }

    /** @return Collection<int, Salarie> */
    public function getSalaries(): Collection { return $this->salaries; }

    public function __toString(): string { return (string) $this->nom; }
}
