<?php

namespace App\Entity;

use App\Repository\TrainRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;

#[ORM\Entity(repositoryClass: TrainRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Patch()
    ],
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']]
)]
#[ApiFilter(SearchFilter::class, properties: ['departureStation' => 'partial', 'arrivalStation' => 'partial'])]
#[ApiFilter(DateFilter::class, properties: ['departureDateTime' => 'before', 'arrivalDateTime'])]
#[ApiFilter(RangeFilter::class, properties: ['seatsAvailableBusiness', 'seatsAvailableFirst', 'seatsAvailableStandard'])]
#[ApiFilter(OrderFilter::class, properties: ['priceBusiness', 'priceFirst', 'priceStandard'])]
class Train
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('read')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('read')]
    private ?string $departureStation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('read')]
    private ?\DateTimeInterface $departureDateTime = null;

    #[ORM\Column(length: 255)]
    #[Groups('read')]
    private ?string $arrivalStation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('read')]
    private ?\DateTimeInterface $arrivalDateTime = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $seatsAvailableBusiness = null;

    #[ORM\Column]
    #[Groups('read')]
    private ?float $priceBusiness = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $seatsAvailableFirst = null;

    #[ORM\Column]
    #[Groups('read')]
    private ?float $priceFirst = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $seatsAvailableStandard = null;

    #[ORM\Column]
    #[Groups('read')]
    private ?int $priceStandard = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartureStation(): ?string
    {
        return $this->departureStation;
    }

    public function setDepartureStation(string $departureStation): static
    {
        $this->departureStation = $departureStation;

        return $this;
    }

    public function getDepartureDateTime(): ?\DateTimeInterface
    {
        return $this->departureDateTime;
    }

    public function setDepartureDateTime(\DateTimeInterface $departureDateTime): static
    {
        $this->departureDateTime = $departureDateTime;

        return $this;
    }

    public function getArrivalStation(): ?string
    {
        return $this->arrivalStation;
    }

    public function setArrivalStation(string $arrivalStation): static
    {
        $this->arrivalStation = $arrivalStation;

        return $this;
    }

    public function getArrivalDateTime(): ?\DateTimeInterface
    {
        return $this->arrivalDateTime;
    }

    public function setArrivalDateTime(\DateTimeInterface $arrivalDateTime): static
    {
        $this->arrivalDateTime = $arrivalDateTime;

        return $this;
    }

    public function getSeatsAvailableBusiness(): ?int
    {
        return $this->seatsAvailableBusiness;
    }

    public function setSeatsAvailableBusiness(int $seatsAvailableBusiness): static
    {
        $this->seatsAvailableBusiness = $seatsAvailableBusiness;

        return $this;
    }

    public function getPriceBusiness(): ?float
    {
        return $this->priceBusiness;
    }

    public function setPriceBusiness(float $priceBusiness): static
    {
        $this->priceBusiness = $priceBusiness;

        return $this;
    }

    public function getSeatsAvailableFirst(): ?int
    {
        return $this->seatsAvailableFirst;
    }

    public function setSeatsAvailableFirst(int $seatsAvailableFirst): static
    {
        $this->seatsAvailableFirst = $seatsAvailableFirst;

        return $this;
    }

    public function getPriceFirst(): ?float
    {
        return $this->priceFirst;
    }

    public function setPriceFirst(float $priceFirst): static
    {
        $this->priceFirst = $priceFirst;

        return $this;
    }

    public function getSeatsAvailableStandard(): ?int
    {
        return $this->seatsAvailableStandard;
    }

    public function setSeatsAvailableStandard(int $seatsAvailableStandard): static
    {
        $this->seatsAvailableStandard = $seatsAvailableStandard;

        return $this;
    }

    public function getPriceStandard(): ?int
    {
        return $this->priceStandard;
    }

    public function setPriceStandard(int $priceStandard): static
    {
        $this->priceStandard = $priceStandard;

        return $this;
    }
}
