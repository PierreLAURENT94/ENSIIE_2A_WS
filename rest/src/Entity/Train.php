<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TrainRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainRepository::class)]
#[ApiResource]
class Train
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lieu $Depart = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lieu $Arrivee = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?BilletClasseDispo $Billets = null;

    public function getDepart(): ?Lieu
    {
        return $this->Depart;
    }

    public function setDepart(Lieu $Depart): static
    {
        $this->Depart = $Depart;

        return $this;
    }

    public function getArrivee(): ?Lieu
    {
        return $this->Arrivee;
    }

    public function setArrivee(Lieu $Arrivee): static
    {
        $this->Arrivee = $Arrivee;

        return $this;
    }

    public function getBillets(): ?BilletClasseDispo
    {
        return $this->Billets;
    }

    public function setBillets(BilletClasseDispo $Billets): static
    {
        $this->Billets = $Billets;

        return $this;
    }

}
