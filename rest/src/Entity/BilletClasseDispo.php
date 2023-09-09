<?php

namespace App\Entity;

use App\Repository\BilletClasseDispoRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: BilletClasseDispoRepository::class)]
#[ApiResource]
class BilletClasseDispo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Premiere = null;

    #[ORM\Column]
    private ?int $Premium = null;

    #[ORM\Column]
    private ?int $Standard = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPremiere(): ?int
    {
        return $this->Premiere;
    }

    public function setPremiere(int $Premiere): static
    {
        $this->Premiere = $Premiere;

        return $this;
    }

    public function getPremium(): ?int
    {
        return $this->Premium;
    }

    public function setPremium(int $Premium): static
    {
        $this->Premium = $Premium;

        return $this;
    }

    public function getStandard(): ?int
    {
        return $this->Standard;
    }

    public function setStandard(int $Standard): static
    {
        $this->Standard = $Standard;

        return $this;
    }
}
