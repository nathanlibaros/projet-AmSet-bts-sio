<?php

namespace App\Entity;

use App\Repository\LangueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LangueRepository::class)]
#[ORM\Table(name: 'langue')]
class Langue
{
    /**
     * Code de la langue : fr, en, es...
     */
    #[ORM\Id]
    #[ORM\Column(name: 'code_langue', length: 5)]
    private ?string $code = null;

    #[ORM\Column(name: 'nom_langue', length: 50)]
    private ?string $nom = null;

    public function getCode(): ?string { return $this->code; }
    public function setCode(string $code): static { $this->code = $code; return $this; }

    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $nom): static { $this->nom = $nom; return $this; }

    public function __toString(): string { return (string) $this->nom; }
}
