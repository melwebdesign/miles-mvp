<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $status = 'pending';

    public function __construct(
        #[ORM\ManyToOne(inversedBy: 'pickupDatetime')]
        #[ORM\JoinColumn(nullable: false)]
        private ?Vehicle            $vehicle = null,

        #[ORM\Column]
        private ?\DateTimeImmutable $pickupDatetime = null,

        #[ORM\Column]
        private ?\DateTimeImmutable $returnDatetime = null,

        #[ORM\Column(length: 255)]
        private ?string             $pickupCity = null,

        #[ORM\Column(length: 255)]
        private ?string             $returnCity = null,

        #[ORM\Column]
        private ?bool               $returnAtDifferentLocation = null,
    )
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): static
    {
        $this->vehicle = $vehicle;

        return $this;
    }


    public function getPickupDatetime(): ?\DateTimeImmutable
    {
        return $this->pickupDatetime;
    }

    public function setPickupDatetime(\DateTimeImmutable $pickupDatetime): static
    {
        $this->pickupDatetime = $pickupDatetime;

        return $this;
    }

    public function getReturnDatetime(): ?\DateTimeImmutable
    {
        return $this->returnDatetime;
    }

    public function setReturnDatetime(\DateTimeImmutable $returnDatetime): static
    {
        $this->returnDatetime = $returnDatetime;

        return $this;
    }

    public function isReturnAtDifferentLocation(): ?bool
    {
        return $this->returnAtDifferentLocation;
    }

    public function setReturnAtDifferentLocation(bool $returnAtDifferentLocation): static
    {
        $this->returnAtDifferentLocation = $returnAtDifferentLocation;

        return $this;
    }

    public function getPickupCity(): ?string
    {
        return $this->pickupCity;
    }

    public function setPickupCity(string $pickupCity): static
    {
        $this->pickupCity = $pickupCity;

        return $this;
    }

    public function getReturnCity(): ?string
    {
        return $this->returnCity;
    }

    public function setReturnCity(string $returnCity): static
    {
        $this->returnCity = $returnCity;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'pickupDatetime' => $this->pickupDatetime->format('Y-m-d H:i'),
            'returnDatetime' => $this->returnDatetime->format('Y-m-d H:i'),
            'pickupCity' => $this->pickupCity,
            'returnCity' => $this->returnCity,
            'returnAtDifferentLocation' => $this->returnAtDifferentLocation,
            'vehicle' => $this->vehicle,
        ];
    }

}
