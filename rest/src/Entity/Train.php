<?php

namespace App\Entity;

use App\Repository\TrainRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Exception\SeatsAvailableException;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\ApiFilter;
// use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;   @TODO custom filter pour Objet Station 
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\OpenApi\Model;

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
// #[ApiFilter(SearchFilter::class, properties: ['departureStation.city' => 'partial', 'arrivalStation.city' => 'partial'])]   @TODO custom filter pour Objet Station 
#[ApiFilter(NumericFilter::class, properties: ['departureStation.id', 'arrivalStation.id'])]
#[ApiFilter(DateFilter::class, properties: ['departureDateTime', 'arrivalDateTime'])]
#[ApiFilter(RangeFilter::class, properties: ['seatsAvailableBusiness', 'seatsAvailableFirst', 'seatsAvailableStandard'])]
#[ApiFilter(OrderFilter::class, properties: ['priceBusiness', 'priceFirst', 'priceStandard'])]
#[Patch(
    openapi: new Model\Operation(
        summary: 'Updates available seats in the Train resource.', 
        description: 'Updates available seats in the Train resource.',
        requestBody: new Model\RequestBody(
            content: new \ArrayObject([
                'application/merge-patch+json' => [
                    'schema' => [
                        'type' => 'object', 
                        'properties' => [
                            'seatsAvailableBusiness' => ['type' => 'integer'], 
                            'seatsAvailableFirst' => ['type' => 'integer'],
                            'seatsAvailableStandard' => ['type' => 'integer']
                        ]
                    ], 
                    'example' => [
                        'seatsAvailableStandard' => 82
                    ]
                ]
            ])
        )
    )
)]
class Train
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('read')]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('read')]
    private ?Station $departureStation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('read')]
    private ?\DateTimeInterface $departureDateTime = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('read')]
    private ?Station $arrivalStation = null;

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
    private ?float $priceStandard = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartureStation(): ?Station
    {
        return $this->departureStation;
    }

    public function setDepartureStation(?Station $departureStation): static
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

    public function getArrivalStation(): ?Station
    {
        return $this->arrivalStation;
    }

    public function setArrivalStation(?Station $arrivalStation): static
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
        if($this->getId() && $seatsAvailableBusiness > $this->seatsAvailableBusiness){
            throw new SeatsAvailableException("seatsAvailableBusiness: This value must be less than or equal to " . $this->seatsAvailableBusiness . ".");
            return $this;
        }

        if($seatsAvailableBusiness < 0){
            throw new SeatsAvailableException("seatsAvailableBusiness: This value must be greater than or equal to 0.");
            return $this;
        }

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
        if($this->getId() && $seatsAvailableFirst > $this->seatsAvailableFirst){
            throw new SeatsAvailableException("seatsAvailableFirst: This value must be less than or equal to " . $this->seatsAvailableFirst . ".");
            return $this;
        }

        if($seatsAvailableFirst < 0){
            throw new SeatsAvailableException("seatsAvailableFirst: This value must be greater than or equal to 0.");
            return $this;
        }

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
        if($this->getId() && $seatsAvailableStandard > $this->seatsAvailableStandard){
            throw new SeatsAvailableException("seatsAvailableStandard: This value must be less than or equal to " . $this->seatsAvailableStandard . ".");
            return $this;
        }

        if($seatsAvailableStandard < 0){
            throw new SeatsAvailableException("seatsAvailableStandard: This value must be greater than or equal to 0.");
            return $this;
        }

        $this->seatsAvailableStandard = $seatsAvailableStandard;

        return $this;
    }

    public function getPriceStandard(): ?float
    {
        return $this->priceStandard;
    }

    public function setPriceStandard(float $priceStandard): static
    {
        $this->priceStandard = $priceStandard;

        return $this;
    }
}
